@extends('admin.layouts.app')

@section('admin_page', 'contacts-index')
@section('title', 'Liên hệ')
@section('eyebrow', 'Contacts')
@section('description', 'Theo dõi tin nhắn tư vấn, phản hồi và thông tin liên hệ khách gửi từ trang liên hệ.')

@section('content')
    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="contact-search">Tìm liên hệ</label>
            <input id="contact-search" type="search" placeholder="Nhập tên, email, số điện thoại hoặc nội dung..." data-filter-input="contacts">
        </div>
        <div class="resource-toolbar__meta">
            <span class="metric-pill">Hiển thị <strong data-filter-count="contacts">{{ $contacts->count() }}</strong> mục</span>
            <span class="metric-pill metric-pill--soft">Phản hồi khách hàng</span>
        </div>
    </section>

    @if ($contacts->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách liên hệ</th>
                        <th>Thông tin</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="contacts">
                    @foreach ($contacts as $contact)
                        <tr data-filter-row>
                            <td>#{{ $contact->id }}</td>
                            <td>
                                <strong>{{ $contact->name }}</strong><br>
                                <span class="helper">{{ $contact->email ?: 'Chưa có email' }}</span>
                            </td>
                            <td>
                                {{ $contact->phone ?: 'Chưa có số điện thoại' }}<br>
                                <span class="helper">{{ optional($contact->created_at)->diffForHumans() }}</span>
                            </td>
                            <td class="contact-message-cell">{{ \Illuminate\Support\Str::limit($contact->message, 96) }}</td>
                            <td>{{ optional($contact->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary">Xem</a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa liên hệ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="empty-filter-state" data-filter-empty="contacts" hidden>
            <strong>Không tìm thấy liên hệ phù hợp</strong>
            <p>Hãy thử tìm theo tên, email, số điện thoại hoặc nội dung tin nhắn.</p>
        </div>

        <div class="pagination">
            {{ $contacts->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có liên hệ</strong>
            <p>Tin nhắn từ trang liên hệ sẽ hiển thị tại đây khi khách gửi yêu cầu tư vấn.</p>
        </div>
    @endif
@endsection
