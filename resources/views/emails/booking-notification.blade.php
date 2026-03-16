<!DOCTYPE html>
<html lang="en">
    <body style="margin:0;padding:24px;background:#f8fafc;font-family:Arial,sans-serif;color:#0f172a;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;">
            <tr>
                <td style="padding:20px 24px;background:{{ $brand['colors']['primary'] }};color:#ffffff;">
                    <h1 style="margin:0;font-size:24px;">New Booking Alert</h1>
                </td>
            </tr>
            <tr>
                <td style="padding:24px;">
                    <p style="margin-top:0;">A new booking has been submitted.</p>
                    <h2 style="margin:24px 0 8px 0;font-size:18px;">Patient details</h2>
                    <p style="margin:0 0 8px 0;"><strong>Name:</strong> {{ $booking->patient_name }}</p>
                    <p style="margin:0 0 8px 0;"><strong>Email:</strong> {{ $booking->patient_email }}</p>
                    <p style="margin:0 0 8px 0;"><strong>Phone:</strong> {{ $booking->patient_phone ?: 'N/A' }}</p>
                    <p style="margin:0 0 16px 0;"><strong>Notes:</strong> {{ $booking->notes ?: 'N/A' }}</p>

                    <h2 style="margin:24px 0 8px 0;font-size:18px;">Appointment</h2>
                    <p style="margin:0 0 8px 0;"><strong>Service:</strong> {{ $booking->service->name }}</p>
                    <p style="margin:0 0 8px 0;"><strong>Date:</strong> {{ $booking->timeSlot->date->format('l, F j, Y') }}</p>
                    <p style="margin:0 0 16px 0;"><strong>Time:</strong> {{ substr((string) $booking->timeSlot->starts_at, 0, 5) }} - {{ substr((string) $booking->timeSlot->ends_at, 0, 5) }}</p>

                    <a href="{{ rtrim(config('app.url'), '/') }}/admin" style="display:inline-block;padding:10px 16px;background:{{ $brand['colors']['accent'] }};color:#111827;text-decoration:none;border-radius:8px;">Open Admin Panel</a>
                </td>
            </tr>
        </table>
    </body>
</html>
