@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i>Development OTP Codes
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This page shows the latest OTP codes for testing purposes. Only available in local development environment.
                    </div>

                    @if($otps->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                                        <th><i class="fas fa-hashtag me-1"></i>OTP Code</th>
                                        <th><i class="fas fa-tag me-1"></i>Type</th>
                                        <th><i class="fas fa-clock me-1"></i>Expires At</th>
                                        <th><i class="fas fa-check me-1"></i>Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($otps as $otp)
                                        <tr class="{{ $otp->used ? 'table-secondary' : '' }}">
                                            <td>
                                                <strong>{{ $otp->email }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6 px-3 py-2">
                                                    {{ $otp->code }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $otp->type === 'login' ? 'bg-success' : 'bg-info' }}">
                                                    {{ ucfirst($otp->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ $otp->expires_at->format('M j, H:i:s') }}
                                                </span>
                                                @if($otp->expires_at->isPast())
                                                    <span class="badge bg-danger ms-1">Expired</span>
                                                @else
                                                    <span class="badge bg-success ms-1">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($otp->used)
                                                    <i class="fas fa-check text-success"></i>
                                                @else
                                                    <i class="fas fa-times text-muted"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('dev.otp-codes') }}" class="btn btn-outline-primary">
                                <i class="fas fa-refresh me-1"></i>Refresh
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No OTP codes found</h5>
                            <p class="text-muted">Try logging in or registering to generate OTP codes.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-terminal me-2"></i>Laravel Logs</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">OTP codes are also logged to Laravel logs for easy access:</p>
                    <code class="d-block p-3 bg-light rounded">
tail -f storage/logs/laravel.log | grep "🔐"
                    </code>
                    <small class="text-muted">Run this command in your terminal to monitor OTP codes in real-time.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection