import Footer from '@/Components/layout/Footer';
import Navbar from '@/Components/layout/Navbar';
import type { PageProps } from '@/types/models';
import { usePage } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';

export default function Layout({ children }: PropsWithChildren) {
    const { flash } = usePage<PageProps>().props;

    return (
        <div className="min-h-screen">
            <Navbar />
            {flash?.success && (
                <div className="mx-auto mt-6 max-w-6xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-200">
                    {flash.success}
                </div>
            )}
            {flash?.error && (
                <div className="mx-auto mt-6 max-w-6xl rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-200">
                    {flash.error}
                </div>
            )}
            <main>{children}</main>
            <Footer />
        </div>
    );
}