export const cn = (...classes: Array<string | false | null | undefined>) =>
    classes.filter(Boolean).join(' ');

export const formatCurrency = (value: number | string) =>
    new Intl.NumberFormat('de-AT', {
        style: 'currency',
        currency: 'EUR',
    }).format(Number(value));
