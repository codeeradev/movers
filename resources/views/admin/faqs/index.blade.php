@extends('admin.layouts.dashboard')

@section('title', 'FAQ Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">FAQ Management</h3>
            <small class="text-muted">Manage questions and answers shown on the frontend</small>
        </div>
        <a href="{{ route('faqs.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add FAQ
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="faqTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th width="12%">For</th>
                            <th width="18%">Target</th>
                            <th width="10%">Order</th>
                            <th width="10%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="faqDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalQuestion"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size:15px;line-height:1.8;color:#1f2933">
                <div class="mb-3">
                    <span class="badge badge-light text-dark" id="faqModalStatus"></span>
                </div>
                <div class="mb-3" id="faqModalTarget"></div>
                <div id="faqModalAnswer"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .card { border-radius: 12px; }
    .table td, .table th { vertical-align: middle; }
    .dataTables_filter input { border-radius: 20px; padding: 6px 12px; }
    .faq-answer-preview { color: #4b5563; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    let table = $('#faqTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        scrollX: true,
        ajax: "{{ route('faqs.ajax') }}",
        columns: [
            { data: 'sr' },
            { data: 'question' },
            { data: 'answer' },
            { data: 'scope' },
            { data: 'target' },
            { data: 'sort_order' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ],
        language: {
            search: "",
            searchPlaceholder: "Search FAQs..."
        }
    });

    $(document).on('click', '.view-detail', function () {
        let id = $(this).data('id');

        $.get('/faqs/' + id, function (res) {
            $('#faqModalQuestion').text(res.question);
            $('#faqModalStatus').text(res.status);
            let target = 'Home Page';
            if (res.scope === 'service') {
                target = `Service${res.service ? ': ' + res.service : ''}`;
            } else if (res.scope === 'blog') {
                target = `Blog${res.blog ? ': ' + res.blog : ''}`;
            }
            $('#faqModalTarget').html(`<span class="badge badge-info">${target}</span>`);
            $('#faqModalAnswer').html(`<p>${res.answer.replace(/\n/g, '<br>')}</p>`);

            const faqModal = new bootstrap.Modal(document.getElementById('faqDetailModal'));
            faqModal.show();
        });
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete FAQ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/faqs/' + id, {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                }, function () {
                    Swal.fire('Deleted', '', 'success');
                    table.ajax.reload(null, false);
                });
            }
        });
    });
});
</script>
@endpush
