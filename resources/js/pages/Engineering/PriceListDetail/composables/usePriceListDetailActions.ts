import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export function usePriceListDetailActions() {
    const redirectToUnitPrice = (priceListId: number) => {
        if (!priceListId) {
            return;
        }

        router.visit(route('unit-price.index', priceListId));
    };

    return {
        redirectToUnitPrice,
    };
}
