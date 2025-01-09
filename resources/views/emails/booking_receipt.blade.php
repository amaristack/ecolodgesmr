<!-- filepath: /c:/Users/jerom/Desktop/project_sibugay/resources/views/emails/booking_receipt.blade.php -->
@component('mail::message')
# Booking Receipt

Thank you for your booking! Here are your booking details:

@component('mail::table')
| **Booking ID**       | {{ $booking->booking_id }}                |
|----------------------|------------------------------------------|
| **Booking Date**     | {{ \Carbon\Carbon::parse($booking->created_at)->format('F j, Y') }} |
| **Check-in Date**    | {{ \Carbon\Carbon::parse($booking->check_in)->format('F j, Y') }}   |
| **Check-out Date**   | {{ \Carbon\Carbon::parse($booking->check_out)->format('F j, Y') }}  |
| **Type**             | @if($booking->room_id) Room
  @elseif($booking->pool_id) Cottage
  @elseif($booking->activity_id) Activity
  @elseif($booking->hall_id) Hall
  @else N/A
  @endif |
| **Booking Status**   | {{ $booking->booking_status }}          |
| **Payment Status**   | {{ $booking->payment_status }}          |
| **Total Amount**     | PHP {{ number_format($booking->total_amount, 2) }}       |
| **Paid Amount**      | PHP {{ number_format($booking->payment_amount, 2) }}     |
| **Balance Due**      | PHP {{ number_format($booking->balance_due, 2) }}       |
@endcomponent

### Guest Information

@component('mail::table')
| **Name**             | {{ $booking->user->first_name }} {{ $booking->user->last_name }} |
|----------------------|-----------------------------------------------------------------------|
| **Email**            | {{ $booking->user->email }}                                            |
| **Contact Number**   | {{ $booking->user->phone_number }}                                     |
| **Special Requests** | {{ $booking->special_requests ?? 'None' }}                             |
| **Guest Names**      | @if(is_array($booking->guest_names) && !empty($booking->guest_names))
@foreach($booking->guest_names as $guest)
- {{ $guest }}
@endforeach
@else
N/A
@endif |
@endcomponent

@component('mail::button', ['url' => route('view.booking')])
View Booking
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
