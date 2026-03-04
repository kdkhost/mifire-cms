/* ============================================================
   MiFire CMS - Input Masks
   Uses vanilla-masker for Brazilian format masks
   ============================================================ */

import VMasker from 'vanilla-masker';

/**
 * Mask definitions
 */
const MASKS = {
    phone: {
        // Dynamically switch between landline and mobile
        apply(el) {
            const handler = (e) => {
                const value = e.target.value.replace(/\D/g, '');
                VMasker(e.target).unMask();
                if (value.length > 10) {
                    VMasker(e.target).maskPattern('(99) 99999-9999');
                } else {
                    VMasker(e.target).maskPattern('(99) 9999-9999');
                }
                // Maintain cursor position if possible
                const cursor = e.target.selectionStart;
                e.target.setSelectionRange(cursor, cursor);
            };
            el.addEventListener('input', handler);
            // Apply initial mask
            const initialValue = el.value.replace(/\D/g, '');
            if (initialValue.length > 10) {
                VMasker(el).maskPattern('(99) 99999-9999');
            } else {
                VMasker(el).maskPattern('(99) 9999-9999');
            }
        },
    },

    cpf: {
        apply(el) {
            VMasker(el).maskPattern('999.999.999-99');
        },
    },

    cnpj: {
        apply(el) {
            VMasker(el).maskPattern('99.999.999/9999-99');
        },
    },

    cep: {
        apply(el) {
            VMasker(el).maskPattern('99999-999');
        },
    },

    date: {
        apply(el) {
            VMasker(el).maskPattern('99/99/9999');
        },
    },

    money: {
        apply(el) {
            VMasker(el).maskMoney({
                precision: 2,
                separator: ',',
                delimiter: '.',
                unit: 'R$ ',
                zeroCents: false,
            });
        },
    },

    document: {
        // Auto-detect CPF or CNPJ by length
        apply(el) {
            const handler = (e) => {
                const value = e.target.value.replace(/\D/g, '');
                VMasker(e.target).unMask();
                if (value.length <= 11) {
                    VMasker(e.target).maskPattern('999.999.999-99');
                } else {
                    VMasker(e.target).maskPattern('99.999.999/9999-99');
                }
            };
            el.addEventListener('input', handler);
            // Apply initial mask
            const initialValue = el.value.replace(/\D/g, '');
            if (initialValue.length <= 11) {
                VMasker(el).maskPattern('999.999.999-99');
            } else {
                VMasker(el).maskPattern('99.999.999/9999-99');
            }
        },
    },
};

/**
 * Initialize all masks based on data-mask attributes.
 * Usage: <input type="text" data-mask="phone">
 *
 * Supported masks: phone, cpf, cnpj, cep, date, money, document
 */
export function initMasks(container = document) {
    const elements = container.querySelectorAll('[data-mask]');

    elements.forEach((el) => {
        // Skip already masked elements
        if (el.dataset.maskApplied) return;

        const maskType = el.dataset.mask;
        const maskConfig = MASKS[maskType];

        if (maskConfig) {
            maskConfig.apply(el);
            el.dataset.maskApplied = 'true';
        } else {
            console.warn(`[MiFire Masks] Unknown mask type: "${maskType}"`);
        }
    });
}

/**
 * Unmask a value (remove formatting, keep digits only)
 */
export function unmask(value) {
    if (!value) return '';
    return value.replace(/\D/g, '');
}

/**
 * Unmask money value and return as float
 */
export function unmaskMoney(value) {
    if (!value) return 0;
    return parseFloat(
        value
            .replace('R$ ', '')
            .replace(/\./g, '')
            .replace(',', '.')
    ) || 0;
}

/**
 * Format a numeric value as Brazilian currency
 */
export function formatMoney(value) {
    return VMasker.toMoney(value, {
        precision: 2,
        separator: ',',
        delimiter: '.',
        unit: 'R$ ',
        zeroCents: false,
    });
}

/**
 * Apply a specific mask to a single element programmatically
 */
export function applyMask(el, maskType) {
    const maskConfig = MASKS[maskType];
    if (maskConfig) {
        maskConfig.apply(el);
        el.dataset.maskApplied = 'true';
    }
}

// Export functions
export {
    initMasks,
    unmask,
    unmaskMoney,
    formatMoney,
    applyMask,
};

// Global expose for AJAX handler
if (typeof window !== 'undefined') {
    // Global mask initializer
    window.initMasks = initMasks;
}

export default {
    initMasks,
    unmask,
    unmaskMoney,
    formatMoney,
    applyMask,
};
