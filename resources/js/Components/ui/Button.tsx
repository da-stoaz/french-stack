import { cn } from '@/lib/utils';
import type { ButtonHTMLAttributes, PropsWithChildren } from 'react';

type ButtonVariant = 'primary' | 'accent' | 'secondary' | 'ghost';

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: ButtonVariant;
    fullWidth?: boolean;
}

const variantClasses: Record<ButtonVariant, string> = {
    primary:
        'bg-brand-primary text-white hover:opacity-95 dark:bg-brand-primary dark:text-white',
    accent:
        'bg-brand-accent text-slate-900 hover:opacity-95 dark:bg-brand-accent dark:text-slate-900',
    secondary:
        'bg-white text-slate-900 border border-slate-300 hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-100 dark:border-slate-700 dark:hover:bg-slate-800',
    ghost: 'bg-transparent text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800',
};

export default function Button({
    className,
    variant = 'primary',
    fullWidth = false,
    children,
    ...props
}: PropsWithChildren<ButtonProps>) {
    return (
        <button
            className={cn(
                'inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950 disabled:cursor-not-allowed disabled:opacity-60',
                variantClasses[variant],
                fullWidth && 'w-full',
                className,
            )}
            {...props}
        >
            {children}
        </button>
    );
}
