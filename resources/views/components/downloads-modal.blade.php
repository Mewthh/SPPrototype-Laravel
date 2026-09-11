<div class="downloads-modal-overlay is-hidden" id="downloads-modal" role="dialog" aria-modal="true" aria-labelledby="downloads-modal-title">
    <div class="downloads-modal-backdrop" data-close-downloads-modal></div>
    <div class="downloads-modal-card">
        <div class="downloads-modal-header">
            <div>
                <span class="downloads-modal-badge"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg> Resources &amp; Documents</span>
                <h2 class="downloads-modal-title" id="downloads-modal-title">Downloads Directory</h2>
            </div>
            <button type="button" class="downloads-modal-close" data-close-downloads-modal aria-label="Close downloads dialog">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="downloads-modal-body">
            <div class="downloads-directory-container modal-version">
                @if($proceedingsTemplate)
                    <section class="proceedings-template-card">
                        @if($proceedingsTemplate->imageUrl())
                            <img src="{{ $proceedingsTemplate->imageUrl() }}" alt="{{ $proceedingsTemplate->title }}">
                        @endif
                        <div class="proceedings-template-content">
                            <h3>{{ $proceedingsTemplate->title }}</h3>
                            <div class="proceedings-template-actions">
                                @if($proceedingsTemplate->first_label && $proceedingsTemplate->first_url)
                                    <a href="{{ $proceedingsTemplate->first_url }}" class="downloads-year-pill" @if($proceedingsTemplate->first_opens_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $proceedingsTemplate->first_label }}</a>
                                @endif
                                @if($proceedingsTemplate->second_label && $proceedingsTemplate->second_url)
                                    <a href="{{ $proceedingsTemplate->second_url }}" class="downloads-year-pill" @if($proceedingsTemplate->second_opens_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $proceedingsTemplate->second_label }}</a>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif
                <div class="downloads-directory-grid">
                    @foreach($downloadColumns as $column)
                        <div style="display: grid; gap: 36px;">
                            @foreach($column as $category)
                                <div class="downloads-cat-card">
                                    <h3 class="downloads-cat-title">{{ $category->name }}</h3>
                                    <div class="downloads-pill-stack">
                                        @forelse($category->downloads as $download)
                                            <a href="{{ route('downloads.download', $download) }}" class="downloads-year-pill" title="Download {{ $download->title }}">
                                                <span>{{ $download->year }}</span>
                                            </a>
                                        @empty
                                            <span class="downloads-empty-state">No documents yet</span>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="downloads-modal-footer">
            <button type="button" class="button button-secondary" data-close-downloads-modal>Close</button>
        </div>
    </div>
</div>
