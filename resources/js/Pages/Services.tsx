import Layout from '@/Components/layout/Layout';
import Badge from '@/Components/ui/Badge';
import Button from '@/Components/ui/Button';
import Card from '@/Components/ui/Card';
import SectionHeader from '@/Components/ui/SectionHeader';
import { formatCurrency } from '@/lib/utils';
import type { PageProps, Service } from '@/types/models';
import { Head, Link, usePage } from '@inertiajs/react';

type Props = {
    services: Service[];
};

export default function Services({ services }: Props) {
    const { brand } = usePage<PageProps>().props;

    return (
        <Layout>
            <Head>
                <title>Services</title>
                <meta
                    name="description"
                    content={`${brand.name} offers evidence-based physiotherapy treatments in Vienna, including assessments, manual therapy, and sports recovery.`}
                />
            </Head>

            <section className="mx-auto max-w-6xl px-6 py-20">
                <SectionHeader
                    eyebrow="Services"
                    title="Specialist treatment plans for every stage of recovery"
                    description={brand.description}
                />
                <div className="mt-10 grid gap-6 md:grid-cols-2">
                    {services.map((service) => (
                        <Card key={service.id}>
                            <div className="flex items-start justify-between gap-4">
                                <div>
                                    <h3 className="text-2xl font-semibold">{service.name}</h3>
                                    <p className="mt-3 text-sm text-slate-600 dark:text-slate-300">
                                        {service.description}
                                    </p>
                                </div>
                                <Badge>{service.duration_minutes} min</Badge>
                            </div>
                            <div className="mt-6 flex items-center justify-between">
                                <p className="text-lg font-medium">{formatCurrency(service.price)}</p>
                                <Link href={`/book?service=${service.id}`}>
                                    <Button variant="accent">Book service</Button>
                                </Link>
                            </div>
                        </Card>
                    ))}
                </div>
            </section>
        </Layout>
    );
}
