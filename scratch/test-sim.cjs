const fs = require('fs');

const content = fs.readFileSync('resources/views/admin/portal-manager.blade.php', 'utf8');
const scriptMatches = content.match(/<script>([\s\S]*?)<\/script>/gi);
let code = scriptMatches[1].replace(/<\/?script>/gi, '');
code = code.replace(/\{\{[^}]*\}\}/g, '"blade_val"');

// Replace openModalBtns block cleanly
const targetSnippet = `openModalBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setAppInfoCategory('membership');
				});
			});`;
if (!code.includes('openModalBtns')) {
    console.error('Did not find openModalBtns in code!');
} else {
    code = code.replace(/openModalBtns\.forEach\([\s\S]*?\}\);/, '// removed');
}

// Mock a complete browser environment
function getMockEl(tag = 'div', id = '', attrs = {}) {
    const el = {
        tagName: tag.toUpperCase(),
        id: id,
        style: {},
        classList: {
            classes: new Set(),
            toggle(cls, force) {
                if (force !== undefined) {
                    if (force) this.classes.add(cls);
                    else this.classes.delete(cls);
                } else {
                    if (this.classes.has(cls)) this.classes.delete(cls);
                    else this.classes.add(cls);
                }
            },
            add(cls) { this.classes.add(cls); },
            remove(cls) { this.classes.delete(cls); },
            contains(cls) { return this.classes.has(cls); }
        },
        attrs: { ...attrs },
        getAttribute(name) { return this.attrs[name] || ''; },
        setAttribute(name, val) { this.attrs[name] = val; },
        removeAttribute(name) { delete this.attrs[name]; },
        eventListeners: {},
        addEventListener(evt, fn) {
            if (!this.eventListeners[evt]) this.eventListeners[evt] = [];
            this.eventListeners[evt].push(fn);
        },
        dispatchEvent(evt) {
            const fns = this.eventListeners[evt.type || evt] || [];
            fns.forEach(fn => fn.call(this, evt));
        },
        click() {
            this.dispatchEvent({ type: 'click', target: this, preventDefault: () => {} });
        },
        querySelector: (sel) => getMockEl('div'),
        querySelectorAll: (sel) => [getMockEl('div')],
        closest: function(sel) { return this; },
        children: [],
        appendChild: () => {},
        value: '',
        textContent: '',
        innerHTML: ''
    };
    return el;
}

const tabs = [
    getMockEl('a', 'tab-app', { 'data-portal-tab': 'applications' }),
    getMockEl('a', 'tab-roster', { 'data-portal-tab': 'roster' }),
    getMockEl('a', 'tab-inquiries', { 'data-portal-tab': 'inquiries' }),
    getMockEl('a', 'tab-broadcasts', { 'data-portal-tab': 'broadcasts' })
];

const panels = [
    getMockEl('div', 'panel-app', { 'data-portal-panel': 'applications' }),
    getMockEl('div', 'panel-roster', { 'data-portal-panel': 'roster' }),
    getMockEl('div', 'panel-inquiries', { 'data-portal-panel': 'inquiries' }),
    getMockEl('div', 'panel-broadcasts', { 'data-portal-panel': 'broadcasts' })
];

const mockDoc = {
    readyState: 'complete',
    eventListeners: {},
    addEventListener(evt, fn) {
        if (!this.eventListeners[evt]) this.eventListeners[evt] = [];
        this.eventListeners[evt].push(fn);
    },
    querySelectorAll(sel) {
        if (sel === '[data-portal-tab]') return tabs;
        if (sel === '[data-portal-panel]') return panels;
        return [getMockEl('div')];
    },
    querySelector(sel) {
        return getMockEl('div');
    },
    getElementById(id) {
        return getMockEl('div', id);
    }
};

const mockWin = {
    addEventListener: () => {},
    location: { hash: '' }
};

try {
    const fn = new Function('document', 'window', code);
    fn(mockDoc, mockWin);
    console.log('Script evaluated top level successfully');

    // Trigger DOMContentLoaded
    const domLoadedFns = mockDoc.eventListeners['DOMContentLoaded'] || [];
    console.log(`Found ${domLoadedFns.length} DOMContentLoaded listener(s)`);
    domLoadedFns.forEach((f, i) => {
        try {
            f();
            console.log(`DOMContentLoaded listener #${i} succeeded!`);
        } catch (e) {
            console.error(`DOMContentLoaded listener #${i} FAILED:`, e.message);
            console.error(e.stack);
        }
    });

    // Test clicking each tab!
    tabs.forEach(tab => {
        const tabName = tab.getAttribute('data-portal-tab');
        tab.click();
        const activePanels = panels.filter(p => p.style.display === 'block').map(p => p.getAttribute('data-portal-panel'));
        console.log(`After click on ${tabName}, visible panels:`, activePanels);
    });

} catch (err) {
    console.error('TOP LEVEL EVAL ERROR:', err.message);
    console.error(err.stack);
}
