import Layout from '@/Components/layout/Layout';
import Badge from '@/Components/ui/Badge';
import Button from '@/Components/ui/Button';
import Card from '@/Components/ui/Card';
import Input from '@/Components/ui/Input';
import SectionHeader from '@/Components/ui/SectionHeader';
import Select from '@/Components/ui/Select';
import { formatCurrency } from '@/lib/utils';
import type { PageProps, Service, TimeSlot } from '@/types/models';
import { Head, useForm, usePage } from '@inertiajs/react';
import axios from 'axios';
import { FormEvent, useEffect, useMemo, useState } from 'react';

type Props = {
    services: Service[];
    availableDates: string[];
    preselectedServiceId?: string;
};

type FormData = {
    service_id: string;
    time_slot_id: string;
    patient_name: string;
    patient_email: string;
    patient_phone: string;
    notes: string;
};

export default function Book({ services, availableDates, preselectedServiceId }: Props) {
    const { brand } = usePage<PageProps>().props;
    const [selectedDate, setSelectedDate] = useState<string>(availableDates[0] ?? '');
    const [slots, setSlots] = useState<TimeSlot[]>([]);

    const form = useForm<FormData>({
        service_id: preselectedServiceId ?? '',
        time_slot_id: '',
        patient_name: '',
        patient_email: '',
        patient_phone: '',
        notes: '',
    });

    useEffect(() => {
        if (!selectedDate) {
            return;
        }

        axios
            .get('/book/slots', { params: { date: selectedDate } })
            .then((response) => {
                setSlots(response.data.data as TimeSlot[]);
            })
            .catch(() => setSlots([]));
    }, [selectedDate]);

    useEffect(() => {
        form.setData('time_slot_id', '');
    }, [selectedDate]);

    const selectedService = useMemo(
        () => services.find((service) => service.id === form.data.service_id),
        [form.data.service_id, services],
    );

    const selectedSlot = useMemo(
        () => slots.find((slot) => slot.id === form.data.time_slot_id),
        [form.data.time_slot_id, slots],
    );

    const canSubmit =
        form.data.service_id &&
        form.data.time_slot_id &&
        form.data.patient_name &&
        form.data.patient_email;

    const submit = (event: FormEvent) => {
        event.preventDefault();
        form.post('/book');
    };

    return (
        <Layout>
            <Head>
                <title>Book Appointment</title>
                <meta name="description" content={`Book a physiotherapy appointment at ${brand.name}.`} />
            </Head>

            <section className="mx-auto max-w-6xl px-6 py-20">
                <SectionHeader
                    eyebrow="Book"
                    title="Book your appointment"
                    description="Choose your treatment, select a free time slot, and confirm your details."
                />

                <form onSubmit={submit} className="mt-10 grid gap-8 lg:grid-cols-[1.6fr,1fr]">
                    <div className="space-y-6">
                        <Card>
                            <h3 className="text-lg font-semibold">1. Service</h3>
                            <div className="mt-4 space-y-3">
                                <Select
                                    value={form.data.service_id}
                                    onChange={(event) => form.setData('service_id', event.target.value)}
                                >
                                    <option value="">Select a service</option>
                                    {services.map((service) => (
                                        <option key={service.id} value={service.id}>
                                            {service.name}
                                        </option>
                                    ))}
                                </Select>
                                {selectedService ? (
                                    <div className="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                        <Badge>{selectedService.duration_minutes} min</Badge>
                                        <span>{formatCurrency(selectedService.price)}</span>
                                    </div>
                                ) : null}
                            </div>
                        </Card>

                        <Card>
                            <h3 className="text-lg font-semibold">2. Date</h3>
                            <div className="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
                                {availableDates.map((date) => (
                                    <button
                                        key={date}
                                        type="button"
                                        onClick={() => setSelectedDate(date)}
                                        className={`rounded-xl border px-3 py-2 text-sm transition ${
                                            selectedDate === date
                                                ? 'border-brand-primary bg-brand-secondary text-slate-900 dark:border-brand-primary dark:bg-slate-800 dark:text-white'
                                                : 'border-slate-300 hover:border-brand-primary dark:border-slate-700'
                                        }`}
                                    >
                                        {new Date(date).toLocaleDateString()}
                                    </button>
                                ))}
                            </div>
                        </Card>

                        <Card>
                            <h3 className="text-lg font-semibold">3. Time Slot</h3>
                            <div className="mt-4 flex flex-wrap gap-2">
                                {slots.length === 0 ? (
                                    <p className="text-sm text-slate-600 dark:text-slate-300">No slots for this date yet.</p>
                                ) : (
                                    slots.map((slot) => (
                                        <button
                                            key={slot.id}
                                            type="button"
                                            onClick={() => form.setData('time_slot_id', slot.id)}
                                            className={`rounded-full border px-4 py-2 text-sm transition ${
                                                form.data.time_slot_id === slot.id
                                                    ? 'border-brand-primary bg-brand-primary text-white'
                                                    : 'border-slate-300 hover:border-brand-primary dark:border-slate-700'
                                            }`}
                                        >
                                            {slot.starts_at.slice(0, 5)} - {slot.ends_at.slice(0, 5)}
                                        </button>
                                    ))
                                )}
                            </div>
                            {form.errors.time_slot_id ? (
                                <p className="mt-2 text-sm text-rose-600">{form.errors.time_slot_id}</p>
                            ) : null}
                        </Card>

                        <Card>
                            <h3 className="text-lg font-semibold">4. Patient details</h3>
                            <div className="mt-4 grid gap-4">
                                <div>
                                    <Input
                                        placeholder="Full name *"
                                        value={form.data.patient_name}
                                        onChange={(event) => form.setData('patient_name', event.target.value)}
                                    />
                                    {form.errors.patient_name ? (
                                        <p className="mt-1 text-sm text-rose-600">{form.errors.patient_name}</p>
                                    ) : null}
                                </div>
                                <div>
                                    <Input
                                        type="email"
                                        placeholder="Email address *"
                                        value={form.data.patient_email}
                                        onChange={(event) => form.setData('patient_email', event.target.value)}
                                    />
                                    {form.errors.patient_email ? (
                                        <p className="mt-1 text-sm text-rose-600">{form.errors.patient_email}</p>
                                    ) : null}
                                </div>
                                <Input
                                    placeholder="Phone number (optional)"
                                    value={form.data.patient_phone}
                                    onChange={(event) => form.setData('patient_phone', event.target.value)}
                                />
                                <textarea
                                    className="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
                                    rows={4}
                                    placeholder="Notes (optional)"
                                    value={form.data.notes}
                                    onChange={(event) => form.setData('notes', event.target.value)}
                                />
                            </div>
                        </Card>
                    </div>

                    <div>
                        <Card className="sticky top-24">
                            <h3 className="text-lg font-semibold">Summary</h3>
                            <div className="mt-4 space-y-2 text-sm text-slate-700 dark:text-slate-200">
                                <p><strong>Service:</strong> {selectedService?.name ?? 'Not selected'}</p>
                                <p><strong>Date:</strong> {selectedDate ? new Date(selectedDate).toLocaleDateString() : 'Not selected'}</p>
                                <p>
                                    <strong>Time:</strong>{' '}
                                    {selectedSlot
                                        ? `${selectedSlot.starts_at.slice(0, 5)} - ${selectedSlot.ends_at.slice(0, 5)}`
                                        : 'Not selected'}
                                </p>
                                <p><strong>Price:</strong> {selectedService ? formatCurrency(selectedService.price) : '-'}</p>
                            </div>
                            <Button
                                type="submit"
                                variant="accent"
                                fullWidth
                                className="mt-6"
                                disabled={!canSubmit || form.processing}
                            >
                                {form.processing ? 'Submitting...' : 'Submit booking'}
                            </Button>
                        </Card>
                    </div>
                </form>
            </section>
        </Layout>
    );
}
