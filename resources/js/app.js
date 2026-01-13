import './bootstrap';

const storageKey = 'theme';
const themeToggleSelector = '[data-theme-toggle]';

const getStoredTheme = () => {
    const stored = localStorage.getItem(storageKey);
    if (stored === 'dark' || stored === 'light') {
        return stored;
    }
    return null;
};

const getSystemTheme = () => {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';

    const label = isDark ? 'Switch to light mode' : 'Switch to dark mode';

    document.querySelectorAll(themeToggleSelector).forEach((button) => {
        button.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
    });
};

const setTheme = (theme) => {
    localStorage.setItem(storageKey, theme);
    applyTheme(theme);
};

document.addEventListener('DOMContentLoaded', () => {
    const storedTheme = getStoredTheme();
    applyTheme(storedTheme ?? getSystemTheme());

    document.querySelectorAll(themeToggleSelector).forEach((button) => {
        button.addEventListener('click', () => {
            const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
            setTheme(nextTheme);
        });
    });

    if (!storedTheme) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
            applyTheme(event.matches ? 'dark' : 'light');
        });
    }
});
