import { computed, toValue } from 'vue';
import type { MaybeRefOrGetter } from 'vue';

export function useDistributeDate(
    startDate: MaybeRefOrGetter<Date | string | null | undefined>,
    endDate: MaybeRefOrGetter<Date | string | null | undefined>,
) {
    const dateList = computed(() => {
        const startVal = toValue(startDate);
        const endVal = toValue(endDate);

        if (!startVal || !endVal) {
            return [];
        }

        const dates: string[] = [];

        const current = new Date(startVal);
        const stop = new Date(endVal);

        if (isNaN(current.getTime()) || isNaN(stop.getTime())) {
            return [];
        }

        current.setHours(0, 0, 0, 0);
        stop.setHours(0, 0, 0, 0);

        while (current <= stop) {
            dates.push(current.toLocaleDateString('sv-SE'));

            current.setDate(current.getDate() + 1);
        }

        return dates;
    });

    const dayList = computed(() => {
        return dateList.value.map((dateStr) => {
            const day = dateStr.split('-')[2];

            return parseInt(day, 10).toString();
        });
    });

    const monthYearList = computed(() => {
        const list = dateList.value.map((dateStr) => {
            const date = new Date(`${dateStr}T00:00:00`);

            return date.toLocaleDateString('id-ID', {
                month: 'long',
                year: 'numeric',
            });
        });

        return [...new Set(list)];
    });

    const monthYearGroup = computed(() => {
        return dateList.value.reduce(
            (acc, dateStr) => {
                const date = new Date(`${dateStr}T00:00:00`);

                const label = date.toLocaleDateString('id-ID', {
                    month: 'long',
                    year: 'numeric',
                });
                const day = date.getDate().toString();

                let group = acc.find((g) => g.monthYear === label);

                if (!group) {
                    group = { monthYear: label, days: [], dates: [], count: 0 };
                    acc.push(group);
                }

                group!.days.push(day);
                group!.dates.push(dateStr);
                group!.count++;

                return acc;
            },
            [] as Array<{
                monthYear: string;
                days: string[];
                dates: string[];
                count: number;
            }>,
        );
    });

    return {
        dateList,
        dayList,
        monthYearList,
        monthYearGroup,
    };
}
