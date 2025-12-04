<template>
  <span
      :class="computedClasses"
      :style="computedStyles"
      v-bind="$attrs"
      data-slot="badge"
  >
    <slot />
  </span>
</template>

<script>
export default {
    name: 'Badge',
    props: {
        variant: {
            type: String,
            default: 'default'
        },
        color: {
            type: String, // Accepts any valid CSS color
            default: null
        },
        customClass: {
            type: String,
            default: ''
        }
    },
    computed: {
        computedClasses() {
            const baseClasses =
                'inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden';

            const variants = {
                default: 'border-transparent bg-primary text-primary-foreground hover:bg-primary/90',
                secondary: 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/90',
                destructive: 'border-transparent bg-destructive text-white hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60',
                outline: 'text-foreground hover:bg-accent hover:text-accent-foreground',
            };

            // If no custom color is set, use variant classes
            return `${baseClasses} ${!this.color ? (variants[this.variant] || variants.default) : ''} ${this.customClass}`.trim();
        },
        computedStyles() {
            if (!this.color) return null;

            // You can customize more CSS properties if needed
            return {
                backgroundColor: this.color,
                borderColor: this.color,
                color: this.getTextColor(this.color)
            };
        }
    },
    methods: {
        getTextColor(bgColor) {
            if (!bgColor) return 'inherit';

            const hex = bgColor.replace('#', '');
            if (hex.length === 3) {
                const r = parseInt(hex[0] + hex[0], 16);
                const g = parseInt(hex[1] + hex[1], 16);
                const b = parseInt(hex[2] + hex[2], 16);
                return r * 0.299 + g * 0.587 + b * 0.114 > 186 ? 'black' : 'white';
            } else if (hex.length === 6) {
                const r = parseInt(hex.slice(0, 2), 16);
                const g = parseInt(hex.slice(2, 4), 16);
                const b = parseInt(hex.slice(4, 6), 16);
                return r * 0.299 + g * 0.587 + b * 0.114 > 186 ? 'black' : 'white';
            }
            return 'white';
        }
    }
};
</script>
