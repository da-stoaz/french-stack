import Layout from '@/Components/layout/Layout';
import Button from '@/Components/ui/Button';
import Card from '@/Components/ui/Card';
import { formatCurrency } from '@/lib/utils';
import { Head, Link } from '@inertiajs/react';

type Props = {
    bookingSummary?: {
        service: string;
        date: string;
        time: string;
        price: number;
    };
};

export default function Confirmation({ bookingSummary }: Props) {
    return (
        <Layout>
            <Head>
                <title>Booking Confirmed</title>
            </Head>

            <section className="mx-auto max-w-2xl px-6 py-24">
                <Card className="text-center">
                    <div className="mx-auto flex h-20 w-20 animate-pulse items-center justify-center rounded-full bg-brand-secondary text-2xl font-bold text-brand-primary dark:bg-slate-800">
                        OK
                    </div>
                    <h1 className="mt-6 text-3xl font-semibold">Your booking request is in</h1>
                    <p className="mt-3 text-slate-600 dark:text-slate-300">
                        A confirmation email has been sent with your appointment details.
                    </p>

                    {bookingSummary ? (
                        <div className="mt-6 rounded-2xl border border-slate-200 p-4 text-left text-sm dark:border-slate-700">
                            <p><strong>Service:</strong> {bookingSummary.service}</p>
                            <p><strong>Date:</strong> {new Date(bookingSummary.date).toLocaleDateString()}</p>
                            <p><strong>Time:</strong> {bookingSummary.time}</p>
                            <p><strong>Price:</strong> {formatCurrency(bookingSummary.price)}</p>
                        </div>
                    ) : null}

                    <div className="mt-8">
                        <Link href="/">
                            <Button variant="primary">Return home</Button>
                        </Link>
                    </div>
                </Card>
            </section>
        </Layout>
    );
}
