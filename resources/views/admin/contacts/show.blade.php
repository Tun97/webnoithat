@extends('admin.layouts.app')

@section('admin_page', 'contacts-show')
@section('title', 'Chi tiết liên hệ')
@section('eyebrow', 'Contacts')
@section('description', 'Xem đầy đủ thông tin khách gửi từ form liên hệ và xử lý phản hồi khi cần.')

@section('actions')
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--detail">
        <article class="surface-panel detail-panel">
            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>#{{ $contact->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Họ tên</span>
                    <strong>{{ $contact->name }}</strong>
                </div>
                <div class="detail-item">
                    <span>Email</span>
                    <strong>{{ $contact->email ?: 'Chưa có email' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Số điện thoại</span>
                    <strong>{{ $contact->phone ?: 'Chưa có số điện thoại' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Ngày gửi</span>
                    <strong>{{ optional($contact->created_at)->format('d/m/Y H:i') }}</strong>
                </div>
            </div>

            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="contact-delete-form" onsubmit="return confirm('Xóa liên hệ này?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa liên hệ</button>
            </form>
        </article>

        <article class="surface-panel contact-message-panel">
            <div class="panel-kicker">Nội dung</div>
            <h2>Tin nhắn khách gửi</h2>
            <div class="contact-message-box">
                {{ $contact->message }}
            </div>
        </article>
    </section>
@endsection
