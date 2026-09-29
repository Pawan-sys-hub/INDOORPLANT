@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Store Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- HERO BANNER --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-image me-1 text-success"></i>Hero Banner</h6>
                    @if($settings['hero_banner_image'])
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $settings['hero_banner_image']) }}" class="img-fluid rounded-3" style="max-height:180px;object-fit:cover;width:100%" alt="Hero Banner">
                        <p class="text-muted small mt-1">Current banner image</p>
                    </div>
                    @else
                    <div class="border-2 border-dashed rounded-3 text-center py-4 mb-3 text-muted" style="border:2px dashed #ccc">
                        <i class="bi bi-image display-5 d-block mb-2 text-muted"></i>
                        <p class="mb-0 small">No banner image set</p>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Upload New Banner</label>
                        <input type="file" name="hero_banner" class="form-control @error('hero_banner') is-invalid @enderror" accept="image/*">
                        @error('hero_banner') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">JPG, PNG or WebP. Max 4 MB. Recommended: 1600×600 px.</div>
                    </div>
                </div>
            </div>

            {{-- HERO TEXT --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-type me-1 text-success"></i>Hero Text</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Headline</label>
                        <input type="text" name="hero_headline" class="form-control @error('hero_headline') is-invalid @enderror"
                               value="{{ old('hero_headline', $settings['hero_headline']) }}" placeholder="Bring the Outdoors In">
                        @error('hero_headline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Sub-text</label>
                        <textarea name="hero_subtext" class="form-control @error('hero_subtext') is-invalid @enderror" rows="2"
                                  placeholder="Discover our hand-curated collection...">{{ old('hero_subtext', $settings['hero_subtext']) }}</textarea>
                        @error('hero_subtext') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- DISCOUNT --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-tag me-1 text-success"></i>Global Discount</h6>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Discount Percent (%)</label>
                            <div class="input-group">
                                <input type="number" name="store_discount_percent" class="form-control @error('store_discount_percent') is-invalid @enderror"
                                       value="{{ old('store_discount_percent', $settings['store_discount_percent']) }}"
                                       min="0" max="90">
                                <span class="input-group-text">%</span>
                            </div>
                            @error('store_discount_percent') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="alert alert-info mb-0 small mt-3 mt-md-4">
                                <i class="bi bi-info-circle me-1"></i>
                                Set to <strong>0</strong> to disable global discount. This applies storewide to all products.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-5">
                    <i class="bi bi-floppy me-1"></i>Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
