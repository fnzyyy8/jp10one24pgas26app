import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';

import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import { VBtn, VNumberInput } from 'vuetify/components';
import * as directives from 'vuetify/directives';

const isBrowser = typeof window !== 'undefined';
const currentTheme = isBrowser
    ? localStorage.getItem('theme') || 'light'
    : 'light';
export default createVuetify({
    directives,
    theme: {
        defaultTheme: currentTheme,
    },
    components: {
        ...components,
    },
    aliases: {
        VCurrencyInput: VNumberInput,
        VBtnSubmit: VBtn,
        VBtnCreate: VBtn,
    },

    defaults: {
        VSelect: {
            variant: 'outlined',
            density: 'comfortable',
        },
        VTextField: {
            variant: 'outlined',
            density: 'comfortable',
            autocomplete: 'off',
        },
        VTextarea: {
            variant: 'outlined',
            density: 'comfortable',
        },
        VAutocomplete: {
            variant: 'outlined',
            density: 'comfortable',
            clearable: true,
            autocomplete: 'off',
        },
        VNumberInput: {
            variant: 'outlined',
            density: 'comfortable',
            autocomplete: 'off',
            controlVariant: 'hidden',
        },
        VCombobox: {
            variant: 'outlined',
            density: 'comfortable',
            autocomplete: 'off',
            clearable: true,
        },
        VCurrencyInput: {
            variant: 'outlined',
            density: 'comfortable',
            prefix: 'Rp',
            controlVariant: 'hidden',
            grouping: 'always',
            min: 0,
        },
        VBtnSubmit: {
            variant: 'elevated',
        },
        VBtnCreate: {
            variant: 'elevated',
            prependIcon: 'mdi-plus',
            color: 'success',
        },
    },
});
