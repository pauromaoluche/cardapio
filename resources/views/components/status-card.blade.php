<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-lg-3">
    <div class="card stat-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">{{ $title }}</p>
                    <p class="stat-value {{ $statusid == 4 ? 'text-primary-custom' : '' }}">{{ $value }}</p>
                </div>
                <div class="stat-icon bg-{{ $bg }}">
                    <i class="{{ $icon }}"></i>
                </div>
            </div>
        </div>
    </div>
</div>
