<!DOCTYPE html>
<html lang="en">
    <body style="margin:0;padding:24px;background:#f8fafc;font-family:Arial,sans-serif;color:#0f172a;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;">
            <tr>
                <td style="padding:20px 24px;background:{{ $brand['colors']['accent'] }};color:#111827;">
                    <h1 style="margin:0;font-size:24px;">{{ $brand['name'] }}</h1>
                    <p style="margin:8px 0 0 0;">Appointment request received</p>
                </td>
            </tr>
            <tr>
                <td style="padding:24px;">
                    <p style="margin-top:0;">Hi {{ $booking->patient_name }},</p>
                    <p>Thanks for booking with us. Your request is now pending confirmation.</p>
                    <h2 style="margin:24px 0 8px 0;font-size:18px;">Booking summary</h2>
                    <p style="margin:0 0 8px 0;"><strong>Service:</strong> {{ $booking->service->name }}</p>
                    <p style="margin:0 0 8px 0;"><strong>Date:</strong> {{ $booking->timeSlot->date->format('l, F j, Y') }}</p>
                    <p style="margin:0 0 8px 0;"><strong>Time:</strong> {{ substr((string) $booking->timeSlot->starts_at, 0, 5) }} - {{ substr((string) $booking->timeSlot->ends_at, 0, 5) }}</p>
                    <p style="margin:0 0 16px 0;"><strong>Price:</strong> EUR {{ number_format((float) $booking->service->price, 2) }}</p>
                    <p style="margin:0;">Need to reschedule? Contact us at <a href="mailto:{{ $brand['email'] }}">{{ $brand['email'] }}</a> or {{ $brand['phone'] }}.</p>
                </td>
            </tr>
        </table>
    </body>
</html>
