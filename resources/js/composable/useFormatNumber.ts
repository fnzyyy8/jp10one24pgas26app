export function useFormatNumber() {
    const formatRupiah = (value: number) => {
        if (value === null || value === undefined || value == 0) {
            return 'Rp ,-';
        }

        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(value);

        return formatted.replace(/\./g, ',');
    };

    const formatQty = (value: number | null | undefined) => {
        if (value === null || value === undefined) {
            return '0,00';
        }

        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(value);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    const formatDateTime = (
        dateString: string | Date | null | undefined,
    ): string => {
        if (!dateString) {
            return '';
        }

        const date = new Date(dateString);

        if (Number.isNaN(date.getTime())) {
            return '';
        }

        const pad = (value: number): string => String(value).padStart(2, '0');

        return [
            `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`,
            `T${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`,
        ].join('');
    };

    return { formatRupiah, formatQty, formatDate, formatDateTime };
}
