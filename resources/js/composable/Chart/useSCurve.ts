import { computed } from 'vue';
import type { Ref } from 'vue';

export interface SCurveData {
    date: string;
    plan: number;
    actual: number | null;
    forecast: number | null;
}

export type PeriodFilter = 'daily' | 'weekly';

export interface SCurveChartData extends SCurveData {
    periodLabel: string;
}

const DAY_IN_MS = 24 * 60 * 60 * 1000;

const parseDate = (value: string): Date => {
    const [year, month, day] = value.slice(0, 10).split('-').map(Number);

    return new Date(Date.UTC(year, month - 1, day ?? 1));
};

const formatDateKey = (date: Date): string => {
    return date.toISOString().slice(0, 10);
};

const formatDataLabel = (
    date: Date,
    options: Intl.DateTimeFormatOptions,
): string => {
    return new Intl.DateTimeFormat('id-ID', {
        timeZone: 'UTC',
        ...options,
    }).format(date);
};

const getPeriodKey = (
    date: Date,
    period: PeriodFilter,
    startDate: Date,
): string => {
    if (period === 'daily') {
        return formatDateKey(date);
    }

    const diffInDays = Math.floor(
        (date.getTime() - startDate.getTime()) / DAY_IN_MS,
    );

    const weekIndex = Math.floor(diffInDays / 7);
    const weekStart = new Date(startDate);

    weekStart.setUTCDate(weekStart.getUTCDate() + weekIndex * 7);

    return formatDateKey(weekStart);
};

const getLastAvailableValue = (
    items: SCurveData[],
    key: 'actual' | 'forecast',
): number | null => {
    for (let index = items.length - 1; index >= 0; index--) {
        const value = items[index][key];

        if (value !== null) {
            return value;
        }
    }

    return null;
};

const getPeriodLabel = (
    dateKey: string,
    period: PeriodFilter,
    startDate: Date,
): string => {
    const date = parseDate(dateKey);

    if (period === 'daily') {
        return formatDataLabel(date, {
            day: 'numeric',
            month: 'short',
        });
    }

    const diffInDays = Math.floor(
        (date.getTime() - startDate.getTime()) / DAY_IN_MS,
    );

    return `Week ${Math.floor(diffInDays / 7) + 1}`;
};

export const useSCurve = (
    data: Readonly<Ref<SCurveData[]>>,
    selectedPeriod: Ref<PeriodFilter>,
) => {
    const chartData = computed<SCurveChartData[]>(() => {
        const sortedData = [...data.value].sort((a, b) =>
            a.date.localeCompare(b.date),
        );

        if (sortedData.length === 0) {
            return [];
        }

        const startDate = parseDate(sortedData[0].date);
        const groups = new Map<string, SCurveData[]>();

        for (const item of sortedData) {
            const date = parseDate(item.date);

            const periodKey = getPeriodKey(
                date,
                selectedPeriod.value,
                startDate,
            );

            const group = groups.get(periodKey) ?? [];

            group.push(item);
            groups.set(periodKey, group);
        }

        return Array.from(groups, ([date, items]) => {
            const lastItem = items[items.length - 1];

            return {
                date,
                plan: lastItem.plan,
                actual: getLastAvailableValue(items, 'actual'),
                forecast: getLastAvailableValue(items, 'forecast'),
                periodLabel: getPeriodLabel(
                    date,
                    selectedPeriod.value,
                    startDate,
                ),
            };
        });
    });

    return { chartData };
};
