export interface Service {
    id: string;
    name: string;
    description: string;
    duration_minutes: number;
    price: number;
    is_active: boolean;
}

export interface TimeSlot {
    id: string;
    date: string;
    starts_at: string;
    ends_at: string;
    is_available: boolean;
}

export interface Booking {
    id: string;
    service: Service;
    time_slot: TimeSlot;
    patient_name: string;
    patient_email: string;
    patient_phone?: string;
    notes?: string;
    status: 'pending' | 'confirmed' | 'cancelled';
}

export interface Testimonial {
    id: string;
    author_name: string;
    body: string;
    rating: number;
    is_visible: boolean;
}

export interface PageProps {
    [key: string]: unknown;
    brand: import('./brand').Brand;
    auth: { user?: { id: string; name: string; email: string } };
    flash: { success?: string; error?: string };
}
