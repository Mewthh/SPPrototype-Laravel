@if(config('app.debug'))
<div id="spp-image-debugger" class="spp-image-debugger" style="display: none;">
    <!-- Floating Trigger Pill -->
    <button type="button" id="spp-debug-pill" class="spp-debug-pill" aria-label="Open Image Diagnostics">
        <span class="spp-debug-dot" id="spp-debug-dot"></span>
        <span class="spp-debug-icon">🖼️</span>
        <span class="spp-debug-text" id="spp-debug-pill-text">Images: Checking...</span>
    </button>

    <!-- Diagnostics Drawer / Modal -->
    <div id="spp-debug-modal" class="spp-debug-modal" style="display: none;">
        <div class="spp-debug-backdrop" id="spp-debug-backdrop"></div>
        <div class="spp-debug-card">
            <div class="spp-debug-header">
                <div class="spp-debug-title-wrap">
                    <span class="spp-debug-header-icon">🔍</span>
                    <div>
                        <h3 class="spp-debug-title">Image Diagnostics & Network Health</h3>
                        <p class="spp-debug-subtitle">Debug helper for Cloudflare R2 images</p>
                    </div>
                </div>
                <button type="button" id="spp-debug-close" class="spp-debug-close-btn" aria-label="Close dialog">&times;</button>
            </div>

            <div class="spp-debug-body">
                <!-- Host Health Status Card -->
                <div class="spp-host-card" id="spp-host-card">
                    <div class="spp-host-status-row">
                        <div>
                            <span class="spp-host-label">R2 Storage Host:</span>
                            <code class="spp-host-domain" id="spp-host-domain">Loading...</code>
                        </div>
                        <span class="spp-badge" id="spp-host-badge">Testing...</span>
                    </div>
                    <div class="spp-host-message" id="spp-host-message">
                        Checking direct network connectivity to the storage host...
                    </div>
                    <div class="spp-host-actions">
                        <button type="button" class="spp-btn spp-btn-secondary" id="spp-btn-retest">
                            🔄 Test Host Connection
                        </button>
                        <button type="button" class="spp-btn spp-btn-primary" id="spp-btn-apply-fallbacks">
                            🎨 Swap Broken to SVG Fallbacks
                        </button>
                    </div>
                </div>

                <!-- Summary Counts -->
                <div class="spp-stats-row">
                    <div class="spp-stat-box">
                        <span class="spp-stat-val" id="spp-stat-total">0</span>
                        <span class="spp-stat-lbl">Total Images</span>
                    </div>
                    <div class="spp-stat-box spp-stat-success">
                        <span class="spp-stat-val" id="spp-stat-loaded">0</span>
                        <span class="spp-stat-lbl">Loaded OK</span>
                    </div>
                    <div class="spp-stat-box spp-stat-danger">
                        <span class="spp-stat-val" id="spp-stat-failed">0</span>
                        <span class="spp-stat-lbl">Failed / Blocked</span>
                    </div>
                </div>

                <!-- Explanation / Helpful Guidance -->
                <div class="spp-debug-notice" id="spp-isp-notice" style="display: none;">
                    <strong>ℹ️ Why this happens on your machine:</strong>
                    <p>
                        Your friend on another network/data can see the images because Cloudflare R2 public access is active.
                        However, some Philippine ISPs (PLDT, Converge, Globe) drop packets to Cloudflare Anycast IP range
                        <code>104.18.50.x</code> due to ISP-level IP blocks. Switching to a mobile hotspot or VPN bypasses this instantly.
                    </p>
                </div>

                <!-- Image Details List -->
                <div class="spp-table-wrap">
                    <table class="spp-debug-table">
                        <thead>
                            <tr>
                                <th>Element</th>
                                <th>Status</th>
                                <th>Target URL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="spp-debug-table-body">
                            <tr>
                                <td colspan="4" class="spp-table-empty">Scanning page for images...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="spp-debug-footer">
                <span class="spp-footer-hint">Tip: Open DevTools console and run <code>debugSppImages()</code> for tabular JSON output.</span>
                <button type="button" class="spp-btn spp-btn-secondary" id="spp-btn-console-log">
                    📋 Log to Console
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ─── SPP Image Debugger Styles ─── */
.spp-image-debugger {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 99999;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    font-size: 13px;
    color: #1f2937;
}

.spp-debug-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(0, 0, 0, 0.15);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: 500;
    font-size: 12px;
    color: #374151;
    transition: all 0.2s ease;
    backdrop-filter: blur(8px);
}

.spp-debug-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
}

.spp-debug-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    display: inline-block;
}

.spp-debug-dot.has-errors {
    background: #ef4444;
    animation: sppPulse 1.8s infinite;
}

.spp-debug-dot.is-checking {
    background: #f59e0b;
}

@keyframes sppPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.3); }
}

/* Modal Overlay */
.spp-debug-modal {
    position: fixed;
    inset: 0;
    z-index: 100000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.spp-debug-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
}

.spp-debug-card {
    position: relative;
    z-index: 100001;
    width: 100%;
    max-width: 780px;
    max-height: 85vh;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.spp-debug-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}

.spp-debug-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.spp-debug-header-icon {
    font-size: 24px;
}

.spp-debug-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}

.spp-debug-subtitle {
    margin: 2px 0 0;
    font-size: 12px;
    color: #6b7280;
}

.spp-debug-close-btn {
    background: none;
    border: none;
    font-size: 24px;
    line-height: 1;
    color: #9ca3af;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
}

.spp-debug-close-btn:hover {
    color: #111827;
    background: #e5e7eb;
}

.spp-debug-body {
    padding: 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Host Status Card */
.spp-host-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px 16px;
}

.spp-host-status-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.spp-host-label {
    font-weight: 600;
    color: #475569;
    margin-right: 6px;
}

.spp-host-domain {
    background: #e2e8f0;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
    font-family: monospace;
    color: #0f172a;
}

.spp-badge {
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.spp-badge-ok { background: #d1fae5; color: #065f46; }
.spp-badge-err { background: #fee2e2; color: #991b1b; }
.spp-badge-warn { background: #fef3c7; color: #92400e; }

.spp-host-message {
    margin-top: 8px;
    font-size: 12px;
    color: #64748b;
    line-height: 1.5;
}

.spp-host-actions {
    display: flex;
    gap: 10px;
    margin-top: 12px;
    flex-wrap: wrap;
}

.spp-btn {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.15s ease;
}

.spp-btn-primary {
    background: #2563eb;
    color: #ffffff;
}

.spp-btn-primary:hover {
    background: #1d4ed8;
}

.spp-btn-secondary {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #334155;
}

.spp-btn-secondary:hover {
    background: #f1f5f9;
}

/* Stats Row */
.spp-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.spp-stat-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
}

.spp-stat-val {
    display: block;
    font-size: 22px;
    font-weight: 700;
    color: #111827;
}

.spp-stat-lbl {
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
}

.spp-stat-success .spp-stat-val { color: #059669; }
.spp-stat-danger .spp-stat-val { color: #dc2626; }

/* Notice */
.spp-debug-notice {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    padding: 12px 14px;
    border-radius: 0 8px 8px 0;
    font-size: 12px;
    color: #1e40af;
    line-height: 1.5;
}

.spp-debug-notice p { margin: 4px 0 0; }

/* Table */
.spp-table-wrap {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow-x: auto;
    max-height: 260px;
}

.spp-debug-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    text-align: left;
}

.spp-debug-table th {
    background: #f9fafb;
    padding: 8px 12px;
    font-weight: 600;
    color: #4b5563;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
}

.spp-debug-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.spp-table-url {
    max-width: 280px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    color: #2563eb;
    font-family: monospace;
    font-size: 11px;
}

.spp-tag-loaded { color: #059669; font-weight: 600; }
.spp-tag-failed { color: #dc2626; font-weight: 600; }
.spp-tag-fallback { color: #d97706; font-weight: 600; }

.spp-debug-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
}

.spp-footer-hint {
    font-size: 11px;
    color: #6b7280;
}

/* Dark mode compatibility */
html[data-theme="dark"] .spp-debug-card {
    background: #18181b;
    border-color: #27272a;
    color: #f4f4f5;
}
html[data-theme="dark"] .spp-debug-header,
html[data-theme="dark"] .spp-debug-footer {
    background: #27272a;
    border-color: #3f3f46;
}
html[data-theme="dark"] .spp-debug-title { color: #fafafa; }
html[data-theme="dark"] .spp-host-card {
    background: #27272a;
    border-color: #3f3f46;
}
html[data-theme="dark"] .spp-host-domain {
    background: #3f3f46;
    color: #f4f4f5;
}
html[data-theme="dark"] .spp-stat-box {
    background: #27272a;
    border-color: #3f3f46;
}
html[data-theme="dark"] .spp-stat-val { color: #f4f4f5; }
html[data-theme="dark"] .spp-debug-pill {
    background: rgba(39, 39, 42, 0.95);
    border-color: #3f3f46;
    color: #f4f4f5;
}
html[data-theme="dark"] .spp-debug-table th {
    background: #27272a;
    color: #d4d4d8;
    border-color: #3f3f46;
}
html[data-theme="dark"] .spp-debug-table td {
    border-color: #27272a;
    color: #f4f4f5;
}
</style>

<script>
(function() {
    // ─── SPP Client-side Image Diagnostics Tool ───
    const state = {
        images: [],
        host: null,
        hostReachable: null,
        hostChecked: false,
    };

    function initDebugger() {
        const root = document.getElementById('spp-image-debugger');
        if (!root) return;
        root.style.display = 'block';

        const pill = document.getElementById('spp-debug-pill');
        const modal = document.getElementById('spp-debug-modal');
        const closeBtn = document.getElementById('spp-debug-close');
        const backdrop = document.getElementById('spp-debug-backdrop');
        const btnRetest = document.getElementById('spp-btn-retest');
        const btnFallbacks = document.getElementById('spp-btn-apply-fallbacks');
        const btnConsole = document.getElementById('spp-btn-console-log');

        pill?.addEventListener('click', () => {
            modal.style.display = 'flex';
            runDiagnostics();
        });

        const closeModal = () => { modal.style.display = 'none'; };
        closeBtn?.addEventListener('click', closeModal);
        backdrop?.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'flex') closeModal();
        });

        btnRetest?.addEventListener('click', () => {
            testHostReachability(true);
        });

        btnFallbacks?.addEventListener('click', () => {
            applyAllFallbacks();
        });

        btnConsole?.addEventListener('click', () => {
            printConsoleReport();
        });

        // Auto scan after page load
        setTimeout(() => {
            scanImages();
            testHostReachability(false);
        }, 1200);
    }

    function scanImages() {
        const imgs = Array.from(document.querySelectorAll('img')).filter((img) => {
            // Ignore tiny icons or avatars
            return !img.closest('#user-loading-screen') && !img.closest('#spp-image-debugger');
        });

        state.images = imgs.map((img, index) => {
            const originalSrc = img.dataset.originalSrc || img.getAttribute('src') || '';
            const isR2 = originalSrc.includes('.r2.dev');
            if (isR2 && !state.host) {
                try {
                    const parsed = new URL(originalSrc);
                    state.host = parsed.host;
                } catch (e) {}
            }

            const isLoaded = img.complete && img.naturalWidth > 0;
            const isFallback = img.src.startsWith('data:image/svg+xml');

            // Hook onerror if not yet hooked
            if (!img.dataset.debugHooked) {
                img.dataset.debugHooked = 'true';
                img.addEventListener('error', () => {
                    handleImageError(img);
                });
            }

            return {
                id: index + 1,
                element: img,
                alt: img.alt || '(no alt text)',
                src: originalSrc,
                currentSrc: img.src,
                isR2,
                isLoaded,
                isFallback,
                failed: img.dataset.imageFailed === 'true' || (img.complete && img.naturalWidth === 0 && !img.src.startsWith('data:image')),
            };
        });

        updateUI();
    }

    function handleImageError(img) {
        img.dataset.imageFailed = 'true';
        console.warn('[SPP Image Diagnostics] Image failed to load:', img.src);
        
        // Auto fallback if data-fallback-src is provided
        if (img.dataset.fallbackSrc && img.src !== img.dataset.fallbackSrc) {
            img.src = img.dataset.fallbackSrc;
            img.dataset.isUsingFallback = 'true';
        }

        scanImages();
    }

    function applyAllFallbacks() {
        let count = 0;
        state.images.forEach((item) => {
            const img = item.element;
            const fallback = img.dataset.fallbackSrc;
            if (fallback && img.src !== fallback) {
                img.src = fallback;
                img.dataset.isUsingFallback = 'true';
                count++;
            }
        });
        scanImages();
        alert(`Applied SVG fallbacks to ${count} image(s). Placeholders are now displayed.`);
    }

    async function testHostReachability(forceAlert = false) {
        const domainEl = document.getElementById('spp-host-domain');
        const badgeEl = document.getElementById('spp-host-badge');
        const msgEl = document.getElementById('spp-host-message');
        const noticeEl = document.getElementById('spp-isp-notice');

        const host = state.host || 'pub-f319cd3473e549d8971f976e928a3358.r2.dev';
        if (domainEl) domainEl.textContent = host;
        if (badgeEl) {
            badgeEl.className = 'spp-badge spp-badge-warn';
            badgeEl.textContent = 'Testing...';
        }
        if (msgEl) msgEl.textContent = `Attempting connection to https://${host}/ ... (timeout 4s)`;

        const testUrl = `https://${host}/?_debug_t=${Date.now()}`;
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 4000);

        try {
            // Mode 'no-cors' allows detecting if TCP handshake + TLS succeed even if CORS header is not on root
            await fetch(testUrl, { method: 'HEAD', mode: 'no-cors', signal: controller.signal });
            clearTimeout(timeoutId);
            state.hostReachable = true;

            if (badgeEl) {
                badgeEl.className = 'spp-badge spp-badge-ok';
                badgeEl.textContent = 'Reachable';
            }
            if (msgEl) {
                msgEl.textContent = `✅ Successfully connected to ${host}. Your network can reach Cloudflare R2!`;
            }
            if (noticeEl) noticeEl.style.display = 'none';
            if (forceAlert) alert(`Connection SUCCESS: ${host} is reachable from your browser.`);
        } catch (err) {
            clearTimeout(timeoutId);
            state.hostReachable = false;

            const isTimeout = err.name === 'AbortError';
            if (badgeEl) {
                badgeEl.className = 'spp-badge spp-badge-err';
                badgeEl.textContent = isTimeout ? 'Timed Out (Blocked)' : 'Connection Failed';
            }
            if (msgEl) {
                msgEl.innerHTML = `⚠️ <strong>Connection failed / Timed out</strong>: Packets to <code>${host}</code> could not reach the server. This indicates that your local ISP router is dropping traffic to this Cloudflare R2 IP range.`;
            }
            if (noticeEl) noticeEl.style.display = 'block';
            if (forceAlert) alert(`Connection TIMED OUT: Cannot reach ${host}. Your local ISP is dropping packets to this Cloudflare R2 IP subnet.`);
        }

        updateUI();
    }

    function updateUI() {
        const dot = document.getElementById('spp-debug-dot');
        const pillText = document.getElementById('spp-debug-pill-text');
        const statTotal = document.getElementById('spp-stat-total');
        const statLoaded = document.getElementById('spp-stat-loaded');
        const statFailed = document.getElementById('spp-stat-failed');
        const tableBody = document.getElementById('spp-debug-table-body');

        const total = state.images.length;
        const failed = state.images.filter((i) => i.failed || (i.isFallback && i.element.dataset.isUsingFallback)).length;
        const loaded = state.images.filter((i) => i.isLoaded && !i.failed).length;

        if (statTotal) statTotal.textContent = total;
        if (statLoaded) statLoaded.textContent = loaded;
        if (statFailed) statFailed.textContent = failed;

        if (dot && pillText) {
            if (failed > 0) {
                dot.className = 'spp-debug-dot has-errors';
                pillText.textContent = `Images: ${failed} Failed / Blocked`;
            } else if (loaded > 0) {
                dot.className = 'spp-debug-dot';
                pillText.textContent = `Images: ${loaded}/${total} OK`;
            } else {
                dot.className = 'spp-debug-dot is-checking';
                pillText.textContent = `Images: Checking (${total})`;
            }
        }

        if (tableBody) {
            if (!total) {
                tableBody.innerHTML = '<tr><td colspan="4" class="spp-table-empty">No images found on this page.</td></tr>';
                return;
            }

            tableBody.innerHTML = state.images.map((item) => {
                let statusHtml = '<span class="spp-tag-loaded">✅ Loaded</span>';
                if (item.element.dataset.isUsingFallback === 'true') {
                    statusHtml = '<span class="spp-tag-fallback">🎨 Fallback Active</span>';
                } else if (item.failed) {
                    statusHtml = '<span class="spp-tag-failed">❌ Blocked/Timed Out</span>';
                } else if (!item.isLoaded) {
                    statusHtml = '<span style="color:#6b7280;">⏳ Loading...</span>';
                }

                const displayUrl = item.src || '(inline)';
                return `
                    <tr>
                        <td><strong>${escapeHtml(item.alt)}</strong></td>
                        <td>${statusHtml}</td>
                        <td>
                            <a href="${escapeHtml(displayUrl)}" target="_blank" rel="noopener" class="spp-table-url" title="${escapeHtml(displayUrl)}">
                                ${escapeHtml(displayUrl)}
                            </a>
                        </td>
                        <td>
                            <a href="${escapeHtml(displayUrl)}" target="_blank" rel="noopener" class="spp-btn spp-btn-secondary" style="font-size:10px; padding:3px 8px; text-decoration:none;">
                                Open ↗
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');
        }
    }

    function runDiagnostics() {
        scanImages();
        if (!state.hostChecked) {
            state.hostChecked = true;
            testHostReachability(false);
        }
    }

    function printConsoleReport() {
        console.group('🖼️ [SPP Image Diagnostics Report]');
        console.log('Host:', state.host || 'pub-f319cd3473e549d8971f976e928a3358.r2.dev');
        console.log('Host Reachable:', state.hostReachable === true ? 'YES' : (state.hostReachable === false ? 'NO (ISP Blocked/Timed Out)' : 'Testing'));
        console.table(state.images.map((i) => ({
            Element: i.alt,
            Status: i.failed ? 'FAILED (ISP Blocked)' : (i.element.dataset.isUsingFallback ? 'SVG FALLBACK' : 'LOADED'),
            URL: i.src
        })));
        console.log('Tip: Call debugSppImages() anytime to refresh this table.');
        console.groupEnd();
        alert('Diagnostic report logged to DevTools Console! Press F12 -> Console to view.');
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Expose global helper
    window.debugSppImages = () => {
        scanImages();
        printConsoleReport();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDebugger);
    } else {
        initDebugger();
    }
})();
</script>
@endif
