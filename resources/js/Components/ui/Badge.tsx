import { cn } from '@/lib/utils';
import type { PropsWithChildren } from 'react';

export default function Badge({
    children,
    className,
}: PropsWithChildren<{ className?: string }>) {
    return (
        <span
            className={cn(
                'inline-flex items-center rounded-full bg-brand-secondary px-3 py-1 text-xs font-medium text-slate-800 dark:bg-slate-800 dark:text-slate-100',
                className,
            )}
        >
            {children}
        </span>
    );
}
