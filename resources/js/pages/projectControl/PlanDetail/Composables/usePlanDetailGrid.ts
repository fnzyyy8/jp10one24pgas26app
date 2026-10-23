import type { ColDef, ColGroupDef } from 'ag-grid-community';
import type { MaybeRefOrGetter } from 'vue';
import { computed, toValue } from 'vue';
import type {
    PlanDetailGridRow,
    PlanDetailMonthGroup,
} from '@/pages/projectControl/PlanDetail/Types/PlanDetailGrid.type';
import { getPlanDetailDateField } from '@/pages/projectControl/PlanDetail/Utils/planDetailGrid.utils';

type PlanDetailColumn =
    ColDef<PlanDetailGridRow> | ColGroupDef<PlanDetailGridRow>;
export function usePlanDetailGrid(
    monthYearGroup: MaybeRefOrGetter<PlanDetailMonthGroup[]>,
) {
    const defaultColDef: ColDef<PlanDetailGridRow> = {
        sortable: false,
        filter: false,
        resizable: true,
        suppressMovable: true,
    };

    const columnDefs = computed<PlanDetailColumn[]>(() => {
        const fixedColumns: ColDef<PlanDetailGridRow>[] = [
            {
                field: 'name',
                headerName: 'Judul Pekerjaan',
                pinned: 'left',
                lockPinned: true,
                width: 200,
            },
            {
                field: 'volume',
                headerName: 'Volume',
                pinned: 'left',
                lockPinned: true,
                width: 140,
            },
            {
                field: 'totalVolume',
                headerName: 'Total Volume',
                pinned: 'left',
                lockPinned: true,
                width: 160,
            },
        ];

        const dateGroups: ColGroupDef<PlanDetailGridRow>[] = toValue(
            monthYearGroup,
        ).map((group) => ({
            headerName: group.monthYear,
            children: group.dates.map((date) => ({
                field: getPlanDetailDateField(date),
                headerName: String(Number(date.split('-')[2])),
                width: 65,
                minWidth: 55,
                cellStyle: { textAlign: 'center' },
            })),
        }));

        return [...fixedColumns, ...dateGroups];
    });

    return {
        columnDefs,
        defaultColDef,
    };
}
