@extends('admin.layouts.main')
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

@section('container')
<div class="container">
    <h2>Pending Updates</h2>

    @if ($pendingUpdates->isEmpty())
    <p>No pending updates.</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Bio</th>
                <th>Image</th>
                <th>Video</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingUpdates as $update)
            <tr>
                <td>{{ $update->user->name }}</td>
                <td>{{ $update->bio }}</td>
                <td>
                    <!-- Preview button for Image -->
                    @if($update->image_path)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#imageModal{{ $update->id }}">
                        Preview Image
                    </button>
                    <!-- Image Modal -->
                    <div class="modal fade" id="imageModal{{ $update->id }}" tabindex="-1"
                        aria-labelledby="imageModalLabel{{ $update->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel{{ $update->id }}">Image Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset('storage/'.$update->image_path) }}" alt="Image"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    <!-- Preview button for Video -->
                    @if($update->video_path)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#videoModal{{ $update->id }}">
                        Preview Video
                    </button>
                    <!-- Video Modal -->
                    <div class="modal fade" id="videoModal{{ $update->id }}" tabindex="-1"
                        aria-labelledby="videoModalLabel{{ $update->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="videoModalLabel{{ $update->id }}">Video Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <video controls class="w-100">
                                        <source src="{{ asset('storage/'.$update->video_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.approve-update', $update->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection