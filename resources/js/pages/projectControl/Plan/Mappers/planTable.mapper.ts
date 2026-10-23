import type { Plan } from '@/pages/projectControl/Plan/Types/plan.type';

export interface PlanTableItem extends Plan {
    total: number;
    _groupSection: string;
    _groupCategory: string;
    _groupSubCategory: string;
}

export const GROUP_TABLE = {
    noCategory: 'Tanpa Category',
    noSubCategory: 'Tanpa Sub Category',
} as const;

function normalizedGroup(value: string | null | undefined): string | null {
    const normalized = value?.trim();

    return normalized || null;
}

function toPlanTableItem(plan: Plan): PlanTableItem {
    const category = normalizedGroup(plan.category);
    const subCategory = normalizedGroup(plan.subCategory);

    const price = Number(plan.price ?? 0);
    const volume = Number(plan.volume ?? 0);

    return {
        ...plan,
        total: price * volume,
        _groupSection: plan.section,
        _groupCategory: category ?? GROUP_TABLE.noCategory,
        _groupSubCategory: subCategory ?? GROUP_TABLE.noSubCategory,
    };
}
export function mapPlanToTableItems(plans: Plan[]): PlanTableItem[] {
    return plans.map(toPlanTableItem);
}
