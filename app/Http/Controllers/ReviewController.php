<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReviewApproved;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the reviews for a property.
     */
    public function index(Property $property)
    {
        $reviews = $property->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);
            
        return view('reviews.index', compact('property', 'reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Property $property, Booking $booking = null)
    {
        // Check if user has already reviewed this property
        $existingReview = Review::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->exists();
            
        if ($existingReview) {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You have already reviewed this property.');
        }
        
        // If booking is provided, check if it belongs to the user
        if ($booking && $booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('reviews.create', compact('property', 'booking'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);
        
        // Check if booking belongs to user if provided
        if ($request->filled('booking_id')) {
            $booking = Booking::findOrFail($request->booking_id);
            if ($booking->user_id !== Auth::id()) {
                abort(403);
            }
        }
        
        // Create the review
        $review = new Review([
            'user_id' => Auth::id(),
            'property_id' => $property->id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Requires admin approval
        ]);
        
        $review->save();
        
        return redirect()->route('properties.show', $property)
            ->with('success', 'Your review has been submitted and is pending approval.');
    }

    /**
     * Allow property owner to respond to a review.
     */
    public function respond(Request $request, Review $review)
    {
        $this->authorize('respond', $review);
        
        $request->validate([
            'owner_response' => 'required|string|min:10',
        ]);
        
        $review->update([
            'owner_response' => $request->owner_response,
            'owner_response_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Your response has been saved.');
    }

    /**
     * Allow admin to approve a review.
     */
    public function approve(Review $review)
    {
        $this->authorize('approve', $review);
        
        $review->update([
            'is_approved' => true,
        ]);
        
        // Send notification to the user who wrote the review
        $review->user->notify(new ReviewApproved($review));
        
        return redirect()->back()
            ->with('success', 'Review has been approved and the user has been notified.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();
        
        return redirect()->back()
            ->with('success', 'Review has been deleted.');
    }
}

