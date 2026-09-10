import Alpine from 'alpinejs'
import './prism.js'

const colorScheme = window.matchMedia('(prefers-color-scheme: dark)')
const themeStorageKey = 'starters-creek-theme'
const validTheme = (value) => ['light', 'dark'].includes(value) ? value : null

Alpine.store('theme', {
    dark: false,
    preference: null,
    init() {
        try {
            this.preference = validTheme(localStorage.getItem(themeStorageKey))
        } catch {}
        this.apply()
        colorScheme.addEventListener('change', () => {
            if (!this.preference) this.apply()
        })
        window.addEventListener('storage', (event) => {
            if (event.key !== themeStorageKey && event.key !== null) return
            this.preference = validTheme(event.newValue)
            this.apply()
        })
    },
    toggle() {
        this.preference = this.dark ? 'light' : 'dark'
        try {
            localStorage.setItem(themeStorageKey, this.preference)
        } catch {}
        this.apply()
    },
    apply() {
        this.dark = this.preference ? this.preference === 'dark' : colorScheme.matches
        const theme = this.dark ? 'dark' : 'light'
        document.documentElement.dataset.theme = theme
        document.querySelectorAll('source[data-theme-dark]').forEach((source) => {
            source.media = this.dark ? 'all' : 'not all'
        })
        document.querySelectorAll('meta[data-theme-color]').forEach((meta) => {
            meta.media = meta.dataset.themeColor === theme ? 'all' : 'not all'
        })
    },
})

Alpine.data('navigation', () => ({
    open: false,
    searchOpen: false,
    init() {
        this.media = window.matchMedia('(min-width: 64rem)')
        this.onResize = () => { this.open = false; this.closeSearch(false) }
        this.media.addEventListener('change', this.onResize)
    },
    openSearch() {
        this.open = false
        this.searchOpen = true
        this.$nextTick(() => this.$refs.search.focus())
    },
    closeSearch(restoreFocus = true) {
        if (!this.searchOpen) return
        this.searchOpen = false
        if (restoreFocus) this.$refs.searchButton.focus()
    },
    close() {
        if (this.searchOpen) return this.closeSearch()
        if (this.open) { this.open = false; this.$refs.menuButton.focus() }
    },
    destroy() { this.media.removeEventListener('change', this.onResize) },
}))

Alpine.start()
