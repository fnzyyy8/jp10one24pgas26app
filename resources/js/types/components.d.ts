import type { VBtn } from 'vuetify/labs/VBtn';
import type { VNumberInput } from 'vuetify/labs/VNumberInput';

declare module 'vue' {
    export interface GlobalComponents {
        VCurrencyInput: typeof VNumberInput;
        VBtnSubmit: typeof VBtn;
        VBtnCreate: typeof VBtn;
    }
}

export {};
