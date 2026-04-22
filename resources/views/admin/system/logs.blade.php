@extends('adminlte::page')

@section('title', 'System Logs')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt mr-2"></i>System Logs
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="logs-container" style="max-height: 600px; overflow-y: auto; font-family: 'Courier New', monospace; font-size: 12px; background-color: #1a1a1a; color: #f8f8f2; padding: 15px;">
                            @if(empty($logs))
                                <div class="text-center text-muted" style="color: #f8f8f2 !important;">
                                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                                    <p>No logs found or log file is empty.</p>
                                </div>
                            @else
                                @foreach($logs as $log)
                                    @php
                                        $logLevel = 'info';
                                        $levelColor = '#61dafb'; // default info color

                                        if (str_contains($log, '[EMERGENCY]')) {
                                            $logLevel = 'emergency';
                                            $levelColor = '#ff0080';
                                        } elseif (str_contains($log, '[ALERT]')) {
                                            $logLevel = 'alert';
                                            $levelColor = '#ff6b6b';
                                        } elseif (str_contains($log, '[CRITICAL]')) {
                                            $logLevel = 'critical';
                                            $levelColor = '#ff4757';
                                        } elseif (str_contains($log, '[ERROR]')) {
                                            $logLevel = 'error';
                                            $levelColor = '#ff3838';
                                        } elseif (str_contains($log, '[WARNING]')) {
                                            $logLevel = 'warning';
                                            $levelColor = '#ffa726';
                                        } elseif (str_contains($log, '[NOTICE]')) {
                                            $logLevel = 'notice';
                                            $levelColor = '#42a5f5';
                                        } elseif (str_contains($log, '[INFO]')) {
                                            $logLevel = 'info';
                                            $levelColor = '#61dafb';
                                        } elseif (str_contains($log, '[DEBUG]')) {
                                            $logLevel = 'debug';
                                            $levelColor = '#a4b0be';
                                        }
                                    @endphp
                                    <div class="log-entry mb-2" style="border-left: 3px solid {{ $levelColor }}; padding-left: 10px; background-color: rgba(255,255,255,0.02); border-bottom: 1px solid #333; padding-bottom: 5px;">
                                        <pre style="margin: 0; white-space: pre-wrap; word-break: break-all; color: {{ $levelColor }};">{{ $log }}</pre>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Showing the last 1000 log entries. Auto-refreshes every 10 seconds.
                                </small>
                                <br>
                                <small class="text-muted last-refresh">
                                    <i class="fas fa-clock mr-1"></i>Last refreshed: --
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="refreshLogs()" title="Refresh logs (Ctrl+R)">
                                    <i class="fas fa-sync-alt mr-1"></i>Refresh Logs
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="clearLogs()">
                                    <i class="fas fa-trash mr-1"></i>Clear Logs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .logs-container::-webkit-scrollbar {
        width: 8px;
    }

    .logs-container::-webkit-scrollbar-track {
        background: #2d2d2d;
    }

    .logs-container::-webkit-scrollbar-thumb {
        background: #555;
        border-radius: 4px;
    }

    .logs-container::-webkit-scrollbar-thumb:hover {
        background: #777;
    }

    .log-entry:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Auto-refresh logs every 10 seconds for real-time viewing
    setInterval(function() {
        if (!$('.logs-container').is(':hover')) {
            refreshLogs();
        }
    }, 10000);

    // Add visual indicator for auto-refresh
    updateLastRefreshTime();
});

function refreshLogs() {
    // Show loading indicator
    $('.logs-container').prepend('<div class="refresh-indicator text-center" style="color: #f8f8f2;"><i class="fas fa-spinner fa-spin"></i> Refreshing logs...</div>');

    $.get(window.location.href, function(data) {
        // Extract the logs container content from the response
        var newContent = $(data).find('.logs-container').html();
        $('.logs-container').html(newContent);
        updateLastRefreshTime();

        // Remove loading indicator after a short delay
        setTimeout(function() {
            $('.refresh-indicator').fadeOut().remove();
        }, 500);
    }).fail(function() {
        $('.refresh-indicator').fadeOut().remove();
        toastr.error('Failed to refresh logs');
    });
}

function clearLogs() {
    if (confirm('Are you sure you want to clear all system logs? This action cannot be undone.')) {
        $.post('{{ route("admin.system.clear-logs") }}')
            .done(function(response) {
                if (response.success) {
                    $('.logs-container').html('<div class="text-center text-muted" style="color: #f8f8f2 !important;"><i class="fas fa-check-circle fa-3x mb-3"></i><p>Logs cleared successfully.</p></div>');
                    toastr.success('System logs cleared successfully');
                    updateLastRefreshTime();
                } else {
                    toastr.error('Failed to clear logs');
                }
            })
            .fail(function() {
                toastr.error('Failed to clear logs');
            });
    }
}

function updateLastRefreshTime() {
    var now = new Date();
    var timeString = now.toLocaleTimeString();
    $('.last-refresh').text('Last refreshed: ' + timeString);
}

// Add keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl+R to refresh logs
    if (e.ctrlKey && e.keyCode === 82) {
        e.preventDefault();
        refreshLogs();
        return false;
    }
});
</script>
@endsection