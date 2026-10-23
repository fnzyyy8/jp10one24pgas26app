import type { PlanDetail } from '@/pages/projectControl/PlanDetail/Types/plan.detail';
import type { PlanDetailGridRow } from '@/pages/projectControl/PlanDetail/Types/PlanDetailGrid.type';

export function getPlanDetailDateField(date: string): string {
    return `date${date.replaceAll('-', '_')}`;
}

export function createPlanDetailRow(
    volume: number | null | undefined,
    totalVolume: number | null | undefined,
    planDetails: PlanDetail[],
    dates: string[],
): PlanDetailGridRow {
    const volumeByDate = new Map(
        planDetails
            .filter((detail) => detail.date)
            .map((detail) => [detail.date, detail.volume]),
    );

    const row: PlanDetailGridRow = {
        name: 'Rencana',
        volume: volume ?? '-',
        totalVolume: totalVolume ?? '-',
    };

    for (const date of dates) {
        row[getPlanDetailDateField(date)] = volumeByDate.get(date) ?? '-';
    }

    return row;
}
