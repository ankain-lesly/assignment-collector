/** @type {import('tailwindcss').Config} */
const plugin = require("tailwindcss/plugin");

const generateColorClass = (variable, opacity = false) => {
  if (opacity) {
    return `hsla(var(--hsl-clr-${variable}), ${opacity})`;
  }

  return (props) => {
    const { opacityValue } = props;
    return opacityValue
      ? `hsla(var(--hsl-clr-${variable}), ${opacityValue})`
      : `hsl(var(--hsl-clr-${variable}))`;
  };
};

module.exports = {
  // darkMode: false,
  darkMode: "class",
  // mode: "jit",
  // content: ["./src/**/*.{js,jsx}", "./public/index.html", "*/*.{html,js,php}"],
  // content: ["*/*.{html,js,php}"],
  content: ["./public/**/*.{html,js,php}", "./views/**/*.{html,js,php}"],
  theme: {
    container: {
      padding: {
        DEFAULT: "16px",
      },
    },
    fontSize: {
      xs: ["12px", "16px"],
      sm: ["14px", "20px"],
      base: ["16px", "19.5px"],
      lg: ["18px", "21.94px"],
      xl: ["20px", "24.38px"],
      "2xl": ["24px", "29.26px"],
      "3xl": ["28px", "50px"],
      "4xl": ["48px", "58px"],
      "6xl": ["65px", "1"],
      "8xl": ["96px", "106px"],
    },
    extend: {
      fontFamily: {
        major: ["Major", "sans-serif"],
        krona: ["Krona One", "sans-serif"],
      },
      colors: {
        warning: generateColorClass("warning"),
        primary: generateColorClass("primary"),
        danger: generateColorClass("danger"),
        success: generateColorClass("success"),
        brown: "hsl(13, 43%, 15%)",
        main: generateColorClass("main"),
        white: generateColorClass("white"),
        dark: generateColorClass("dark"),
        light: generateColorClass("light"),
        "dark-l": generateColorClass("dark-l"),
        "white-l": generateColorClass("white-l"),
        "main-variant": generateColorClass("main-variant"),
        muted: generateColorClass("text-muted"),
      },
      boxShadow: {
        "3xl": "0 10px 40px rgba(0, 0, 0, 0.1)",

        bs: "0.25em 0.25em 0.75em hsla(0, 0%, 0%, 0.25), 0.125em 0.125em 0.25em hsla(0, 0%, 0%, 0.15)",
        "bs-2":
          "0 0 0.75em hsla(0, 0%, 0%, 0.25), 0 0 0.25em hsla(0, 0%, 0%, 0.15)",

        "bs-pri":
          "0.25em 0.25em 1.5em hsla(0, 0%, 0%, 0.3), 0em 0em 0.5em hsla(0, 0%, 0%, 0.35)",

        "bs-sec": "0.3rem 0.1rem 2rem hsla(0, 0%, 0%, 0.3)",
      },
      backgroundImage: {
        hero: "url('/static/images/hero-bg-pattern.png')",
        delivery: "url('/static/images/delivery-international.jpg')",
        "v-circular": "url('/static/images/vector-circular.svg')",

        "mode-alpha": "url('/static/images/alpha-mode.jpg')",
        "mode-delivery": "url('/static/images/delivery-mode.jpg')",
        "mode-quote": "url('/static/images/quote-mode.jpg')",
        "mode-overseas": "url('/static/images/overseas-mode.jpg')",
        "package-track": "url('/static/images/banner-tracker.png')",
        "card-graphics": "url('/static/images/card-bg.701e3783.svg')",
        "button-art": "url('/static/images/bg.button-art.svg')",

        gradient: "var(--gradient-bar)",
        "gradient-text": "var(--gradient-text)",
      },
      screens: {
        wide: "1440px",
        xs: "370px",
      },
      backgroundColor: {},
      keyframes: {
        inOpacity: {
          from: {
            opacity: 0,
          },
          to: {
            opacity: 1,
          },
        },
      },
      animation: {
        inOpacity: "inOpacity 300ms ease-in-out 150ms forwards",
      },
    },
  },
  plugins: [
    // Buttons Util
    plugin(({ theme, addBase, addComponent, addUtilities }) => {
      addBase({
        /* CSS Loaders */
        ".loader": {
          width: "40px",
          height: "40px",
          border: "5px solid hsla(var(--hsl-clr-light), 0.5)",
          borderBottomColor: "hsl(var(--hsl-clr-success))",
          borderRadius: "50%",
          transform: "rotate(0)",
          animation: "anim-spin 2s linear infinite",
          display: "block",
          // @apply animate-spin;
        },
        ".inline-text": {
          // @apply animate-spin;
          width: "20px",
          height: "20px",
          // border: 4px solid hsl(var(--hsl-clr-light));
          // border-bottom-color: hsl(var(--hsl-clr-success));
          border: "5px solid hsla(var(--hsl-clr-light), 0.5)",
          borderBottomColor: "hsl(var(--hsl-clr-success))",
          display: "inline-block",
          lineHeight: "1.3",
        },
        /* Details Illustration */
        ".detail": {
          padding: "5px 10px",
          fontSize: "smaller",
          borderRadius: "5px",
        },
      });
      const btnUtilities = {};
      const colors = theme("colors");
      for (const color in colors) {
        let color1;
        if (typeof colors[color] === "object") {
          color1 = colors[color]["600"];
        } else if (typeof colors[color] === "function") {
          color1 = colors[color](color);
        } else {
          continue;
        }
        btnUtilities[`.btn-${color}`] = {
          backgroundColor: color1,
          borderColor: color1,
          color: colors["light"]("light"),
        };
      }
      addUtilities(btnUtilities);
      addUtilities({
        ".flex-center": {
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
        },
      });
    }),
    // Details Util
    plugin(({ theme, addUtilities }) => {
      const detailUtilities = {};
      const colors = theme("colors");
      for (const color in colors) {
        if (typeof colors[color] === "function") {
          const color1 = colors[color];
          const color2 = colors[color](color);
          detailUtilities[`.detail-${color}`] = {
            backgroundColor: `hsla(var(--hsl-clr-${color}), ${0.15})`,
            color: color2,
          };
        }
      }
      addUtilities(detailUtilities);
    }),
  ],
};
