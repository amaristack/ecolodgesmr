@component('mail::message')
<div style="text-align: center; margin-bottom: 30px;">
    <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/logo1.jpg" alt="Eco Lodges Mountain Resort" style="max-width: 220px; height: auto; border-radius: 5px;">
    <h1 style="color: #15803d; margin-top: 15px; font-size: 24px; font-weight: 700;">Booking Confirmation</h1>
</div>

<div style="background-color: #f0fdf4; border-left: 4px solid #15803d; padding: 16px; margin-bottom: 25px; border-radius: 4px;">
    <p style="color: #166534; font-size: 16px; line-height: 1.6em; margin: 0;">
        Dear <strong>{{ $booking->user->first_name }}</strong>,
    </p>
    <p style="color: #166534; font-size: 16px; line-height: 1.6em; margin-top: 10px; margin-bottom: 0;">
        Thank you for choosing Eco Lodges Mountain Resort. Your booking has been received and confirmed. We look forward to providing you with an exceptional stay!
    </p>
</div>

<div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="background-color: #15803d; padding: 12px 20px;">
        <h2 style="color: #ffffff; font-size: 18px; font-weight: bold; margin: 0;">Booking Summary</h2>
    </div>
    <div style="padding: 20px;">
        @component('mail::table')
        | **Booking Reference**   | <span style="font-family: monospace; font-weight: bold; font-size: 15px; letter-spacing: 0.5px;">{{ $booking->booking_id }}</span> |
        |-------------------------|------------------------------------------|
        | **Booking Date**        | {{ \Carbon\Carbon::parse($booking->created_at)->format('F j, Y') }} |
        | **Check-in Date**       | {{ \Carbon\Carbon::parse($booking->check_in)->format('l, F j, Y') }}   |
        | **Check-out Date**      | {{ \Carbon\Carbon::parse($booking->check_out)->format('l, F j, Y') }}  |
        | **Type**                | <span style="font-weight: 600;">@if($booking->room_id) Room
                                   @elseif($booking->pool_id) Cottage
                                   @elseif($booking->activity_id) Activity
                                   @elseif($booking->hall_id) Function Hall
                                   @else N/A
                                   @endif</span> |
        | **Booking Status**      | @if($booking->booking_status == 'Success') <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #dcfce7; color: #15803d;">{{ ucfirst($booking->booking_status) }}</span>
                                   @elseif($booking->booking_status == 'Cancelled') <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #fee2e2; color: #b91c1c;">{{ ucfirst($booking->booking_status) }}</span>
                                   @else <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #dbeafe; color: #1d4ed8;">{{ ucfirst($booking->booking_status) }}</span>
                                   @endif |
        @endcomponent
    </div>
</div>

<div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="background-color: #0369a1; padding: 12px 20px;">
        <h2 style="color: #ffffff; font-size: 18px; font-weight: bold; margin: 0;">Payment Details</h2>
    </div>
    <div style="padding: 20px;">
        @component('mail::table')
        | **Total Amount**     | <span style="font-weight: bold; font-size: 15px;">PHP {{ number_format($booking->total_amount, 2) }}</span> |
        |---------------------|--------------------------------------------------|
        | **Paid Amount**      | PHP {{ number_format($booking->down_payment, 2) }}        |
        | **Balance Due**      | <span style="font-weight: {{ $booking->balance_due > 0 ? 'bold' : 'normal' }}; color: {{ $booking->balance_due > 0 ? '#b91c1c' : '#15803d' }};">PHP {{ number_format($booking->balance_due, 2) }}</span> |
        | **Payment Status**   | @if($booking->payment_status == 'Fully Paid') <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #dcfce7; color: #15803d;">{{ $booking->payment_status }}</span>
                                @elseif($booking->payment_status == 'Partial') <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #fef9c3; color: #854d0e;">{{ $booking->payment_status }}</span>
                                @else <span style="display: inline-block; padding: 4px 10px; font-weight: bold; border-radius: 12px; font-size: 13px; background-color: #dbeafe; color: #1d4ed8;">{{ $booking->payment_status }}</span>
                                @endif |
        @endcomponent
    </div>
</div>

<div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="background-color: #7e22ce; padding: 12px 20px;">
        <h2 style="color: #ffffff; font-size: 18px; font-weight: bold; margin: 0;">Guest Information</h2>
    </div>
    <div style="padding: 20px;">
        @component('mail::table')
        | **Name**             | {{ $booking->user->first_name }} {{ $booking->user->last_name }} |
        |----------------------|-----------------------------------------------------------------------|
        | **Email**            | {{ $booking->user->email }}                                            |
        | **Contact Number**   | {{ $booking->user->phone_number }}                                     |
        @endcomponent

        @if($booking->special_requests)
        <div style="margin-top: 15px; background-color: #faf5ff; padding: 12px; border-radius: 6px; border-left: 3px solid #7e22ce;">
            <h3 style="color: #6b21a8; font-size: 15px; font-weight: bold; margin-top: 0; margin-bottom: 8px;">Special Requests:</h3>
            <p style="color: #581c87; margin: 0; font-size: 14px;">{{ $booking->special_requests }}</p>
        </div>
        @endif

        @if(is_array($booking->guest_names) && !empty($booking->guest_names))
        <div style="margin-top: 15px;">
            <h3 style="color: #4b5563; font-size: 15px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px;">Additional Guests</h3>
            <ul style="padding-left: 20px; color: #4b5563; margin-top: 10px;">
                @foreach($booking->guest_names as $guest)
                <li style="margin-bottom: 5px; font-size: 14px;">{{ $guest }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="background-color: #ca8a04; padding: 12px 20px;">
        <h2 style="color: #ffffff; font-size: 18px; font-weight: bold; margin: 0;">Important Information</h2>
    </div>
    <div style="padding: 20px;">
        <ul style="padding-left: 20px; color: #4b5563; margin-top: 0; margin-bottom: 0;">
            <li style="margin-bottom: 8px; font-size: 14px;"><strong>Check-in:</strong> 2:00 PM</li>
            <li style="margin-bottom: 8px; font-size: 14px;"><strong>Check-out:</strong> 12:00 PM</li>
            <li style="margin-bottom: 8px; font-size: 14px;"><strong>ID Required:</strong> Please present a valid ID and your booking reference upon arrival.</li>
            <li style="margin-bottom: 8px; font-size: 14px;"><strong>Cancellation Policy:</strong> For cancellations, please contact us at least 48 hours before your scheduled arrival.</li>
            <li style="font-size: 14px;"><strong>Balance Payment:</strong> Any remaining balance must be paid upon arrival at the resort.</li>
        </ul>
    </div>
</div>

<div style="text-align: center; margin-bottom: 25px;">
    @component('mail::button', ['url' => route('view.booking'), 'color' => 'success'])
    View My Booking
    @endcomponent
</div>

<div style="margin-top: 30px; background-color: #f8fafc; padding: 20px; border-radius: 8px; text-align: center;">
    <p style="color: #334155; font-size: 15px; margin-bottom: 15px;">
        Need assistance with your reservation?
    </p>
    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
        <div style="display: inline-block; padding: 8px 15px; background-color: #f1f5f9; border-radius: 20px;">
            <span style="color: #475569; font-size: 14px;">📧 <a href="mailto:info@ecolodges.com" style="color: #0284c7; text-decoration: none;">info@ecolodges.com</a></span>
        </div>
        <div style="display: inline-block; padding: 8px 15px; background-color: #f1f5f9; border-radius: 20px;">
            <span style="color: #475569; font-size: 14px;">📞 (63)915 502 2154 </span>
        </div>
    </div>
    <p style="color: #334155; font-size: 15px; margin: 0;">
        We're excited to welcome you to Eco Lodges Mountain Resort!
    </p>
</div>

<div style="margin-top: 30px; text-align: center;">
    <p style="color: #64748b; font-size: 14px; margin-bottom: 5px;">The Eco Lodges Team</p>
</div>

<hr style="border: 0; height: 1px; background: #e2e8f0; margin: 20px 0;">

<div style="color: #94a3b8; font-size: 12px; text-align: center;">
    <p style="margin-bottom: 5px;">© {{ date('Y') }} Eco Lodges Mountain Resort. All rights reserved.</p>
    <p style="margin: 0;">123 Mountain View Road, Sibugay, Philippines</p>
</div>
@endcomponent
