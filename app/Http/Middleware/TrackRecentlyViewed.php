<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackRecentlyViewed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only track property views
        if ($request->route() && $request->route()->getName() === 'properties.show') {
            $propertyId = $request->route('property');
            
            if (is_object($propertyId)) {
                $propertyId = $propertyId->id;
            }
            
            // Get current recently viewed properties
            $recentlyViewed = session('recently_viewed', []);
            
            // Remove the property if it's already in the list
            if (($key = array_search($propertyId, $recentlyViewed)) !== false) {
                unset($recentlyViewed[$key]);
            }
            
            // Add the property to the beginning of the array
            array_unshift($recentlyViewed, $propertyId);
            
            // Keep only the last 10 viewed properties
            $recentlyViewed = array_slice($recentlyViewed, 0, 10);
            
            // Store the updated list in the session
            session(['recently_viewed' => $recentlyViewed]);
        }
        
        return $response;
    }
}