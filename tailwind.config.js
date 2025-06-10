import defaultTheme from 'tailwindcss/defaultTheme';
const { addDynamicIconSelectors } = require("@iconify/tailwind");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flyonui/dist/js/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        h1: {
                            fontSize: theme('fontSize.5xl'),
                            fontWeight: theme('fontWeight.bold'),
                            marginTop: theme('spacing.6'),
                            marginBottom: theme('spacing.4'),
                        },
                        h2: {
                            fontSize: theme('fontSize.4xl'),
                            fontWeight: theme('fontWeight.semibold'),
                            marginTop: theme('spacing.5'),
                            marginBottom: theme('spacing.3'),
                        },
                        h3: {
                            fontSize: theme('fontSize.3xl'),
                            fontWeight: theme('fontWeight.medium'),
                            marginTop: theme('spacing.4'),
                            marginBottom: theme('spacing.2'),
                        },
                    },
                },
            }),
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'), // <-- Add this line
        require("flyonui"),
        require("flyonui/plugin"),
        addDynamicIconSelectors(),
    ],
    flyonui: {
        themes: ["light"],
        vendors: true,
    },
};
