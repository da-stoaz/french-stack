import Layout from '@/Components/layout/Layout';
import Button from '@/Components/ui/Button';
import Card from '@/Components/ui/Card';
import Input from '@/Components/ui/Input';
import { Head, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

type FormData = {
    email: string;
    password: string;
    remember: boolean;
};

export default function Login() {
    const form = useForm<FormData>({
        email: '',
        password: '',
        remember: true,
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();
        form.post('/login');
    };

    return (
        <Layout>
            <Head>
                <title>Login</title>
            </Head>

            <section className="mx-auto max-w-md px-6 py-24">
                <Card>
                    <h1 className="text-2xl font-semibold">Admin Login</h1>
                    <form onSubmit={submit} className="mt-6 space-y-4">
                        <div>
                            <Input
                                type="email"
                                placeholder="Email"
                                value={form.data.email}
                                onChange={(event) => form.setData('email', event.target.value)}
                            />
                            {form.errors.email ? (
                                <p className="mt-1 text-sm text-rose-600">{form.errors.email}</p>
                            ) : null}
                        </div>
                        <div>
                            <Input
                                type="password"
                                placeholder="Password"
                                value={form.data.password}
                                onChange={(event) => form.setData('password', event.target.value)}
                            />
                            {form.errors.password ? (
                                <p className="mt-1 text-sm text-rose-600">{form.errors.password}</p>
                            ) : null}
                        </div>
                        <Button type="submit" variant="primary" fullWidth disabled={form.processing}>
                            {form.processing ? 'Signing in...' : 'Sign in'}
                        </Button>
                    </form>
                </Card>
            </section>
        </Layout>
    );
}
