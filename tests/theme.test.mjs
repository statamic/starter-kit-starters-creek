import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import vm from 'node:vm'

const source = readFileSync(new URL('../resources/js/site.js', import.meta.url), 'utf8').replace(/^import .*$/gm, '')
function boot({ saved = null, systemDark = false, blocked = false } = {}) {
    const callbacks = {}
    const root = { dataset: {} }
    const media = { matches: systemDark, addEventListener: (name, fn) => { callbacks.system = fn } }
    let store
    const context = {
        window: { matchMedia: () => media, addEventListener: (name, fn) => { callbacks[name] = fn } },
        document: { documentElement: root, querySelectorAll: () => [] },
        localStorage: {
            getItem() { if (blocked) throw new Error('Storage denied'); return saved },
            setItem(key, value) { if (blocked) throw new Error('Storage denied'); saved = value },
        },
        Alpine: { store(name, value) { store = value }, data() {}, start() {} },
    }
    vm.runInNewContext(source, context)
    store.init()
    return { store, root, media, callbacks, saved: () => saved }
}

test('system preference applies until the reader makes an explicit choice', () => {
    const app = boot({ systemDark: true })
    assert.equal(app.root.dataset.theme, 'dark')
    app.media.matches = false
    app.callbacks.system()
    assert.equal(app.root.dataset.theme, 'light')
    app.store.toggle()
    assert.equal(app.saved(), 'dark')
    app.callbacks.system()
    assert.equal(app.root.dataset.theme, 'dark')
})

test('persisted light preference overrides a dark system, including reload', () => {
    const app = boot({ saved: 'light', systemDark: true })
    assert.equal(app.store.dark, false)
    app.store.toggle()
    assert.equal(boot({ saved: app.saved() }).store.dark, true)
})

test('blocked storage keeps the switch usable for the current page', () => {
    const app = boot({ blocked: true })
    assert.doesNotThrow(() => app.store.toggle())
    assert.equal(app.root.dataset.theme, 'dark')
})

test('invalid stored values fall back to the system', () => {
    assert.equal(boot({ saved: 'invalid', systemDark: true }).store.dark, true)
})

test('storage events synchronize tabs and clearing restores system preference', () => {
    const app = boot({ saved: 'light', systemDark: true })
    app.callbacks.storage({ key: 'unrelated', newValue: 'dark' })
    assert.equal(app.store.dark, false)
    app.callbacks.storage({ key: 'starters-creek-theme', newValue: 'dark' })
    assert.equal(app.store.dark, true)
    app.callbacks.storage({ key: null, newValue: null })
    assert.equal(app.store.preference, null)
    app.media.matches = false
    app.callbacks.system()
    assert.equal(app.store.dark, false)
})
