<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['property', 'room'])
            ->latest()
            ->paginate(10);
            
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Property $property, Room $room = null)
    {
        return view('bookings.create', compact('property', 'room'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'home_address' => 'required|string',
            'email' => 'required|email',
        ]);

        $room = null;
        $totalPrice = $property->price;
        
        if ($request->filled('room_id')) {
            $room = Room::findOrFail($request->room_id);
            $totalPrice = $room->price_per_night;
        }
        
        // Calculate number of nights
        $checkIn = new \DateTime($request->check_in_date);
        $checkOut = new \DateTime($request->check_out_date);
        $nights = $checkIn->diff($checkOut)->days;
        
        // Calculate total price
        $totalPrice = $totalPrice * $nights;

        // Create booking
        $booking = new Booking([
            'user_id' => Auth::id(),
            'property_id' => $property->id,
            'room_id' => $room ? $room->id : null,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'home_address' => $request->home_address,
            'email' => $request->email,
            'payment_method' => $request->payment_method ?? 'cash',
            'payment_status' => 'pending',
            'booking_status' => 'pending',
        ]);
        
        $booking->save();

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load(['property', 'room', 'user']);
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if ($booking->booking_status === 'pending' || $booking->booking_status === 'confirmed') {
            $booking->update([
                'booking_status' => 'cancelled',
                'payment_status' => 'cancelled',
            ]);
            
            return redirect()->route('bookings.index')
                ->with('success', 'Booking cancelled successfully!');
        }
        
        return redirect()->route('bookings.index')
            ->with('error', 'This booking cannot be cancelled.');
    }
}