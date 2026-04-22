@extends('client.layouts.app')

@section('client_page', 'about')
@section('title', 'Giới thiệu')

@section('content')
    <section class="about-page">
        <article class="about-hero">
            <div class="about-copy">
                <small>Giới thiệu</small>
                <h1>Không gian nội thất được tạo nên từ sự chỉn chu và gu thẩm mỹ riêng.</h1>
                <p>TAT Interior theo đuổi phong cách nội thất sang trọng, chỉn chu và có chiều sâu. Chúng tôi lựa chọn kỹ lưỡng từng sản phẩm để mỗi không gian sống không chỉ đẹp về hình thức mà còn bền vững theo thời gian sử dụng.</p>
                <p>Từ phòng khách, phòng ăn đến phòng ngủ, mỗi bộ sưu tập đều được tuyển chọn nhằm mang đến trải nghiệm sống tinh tế, tiện nghi và đậm dấu ấn cá nhân cho gia chủ.</p>

                <div class="about-actions">
                    <a href="{{ route('client.home') }}" class="about-btn about-btn--primary">Khám phá sản phẩm</a>
                    <a href="#" class="about-btn about-btn--ghost">Liên hệ tư vấn</a>
                </div>
            </div>

            <div class="about-hero__media">
                <img src="{{ $aboutImage }}" alt="About us">
            </div>
        </article>

        <section class="about-grid">
            <article class="about-section">
                <small>Giá trị cốt lõi</small>
                <h2>Tập trung vào trải nghiệm sống đẳng cấp và phù hợp với từng không gian.</h2>
                <p>Chúng tôi tin rằng nội thất không chỉ là vật dụng mà còn là ngôn ngữ kể câu chuyện về phong cách sống. Mỗi sản phẩm được giới thiệu đều hướng đến sự hài hòa giữa thẩm mỹ, công năng và độ bền trong thực tế sử dụng.</p>

                <div class="about-features">
                    <div class="about-feature">
                        <span class="about-feature__icon">✦</span>
                        <div>
                            <strong>Tuyển chọn kỹ lưỡng</strong>
                            <p>Sản phẩm được lựa chọn theo tiêu chí thẩm mỹ, chất liệu và độ hoàn thiện rõ ràng.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <span class="about-feature__icon">✦</span>
                        <div>
                            <strong>Tư vấn theo nhu cầu thực tế</strong>
                            <p>Định hướng giải pháp phù hợp với diện tích, gu thẩm mỹ và ngân sách của khách hàng.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <span class="about-feature__icon">✦</span>
                        <div>
                            <strong>Đồng hành lâu dài</strong>
                            <p>Không chỉ bán sản phẩm, TAT còn hướng tới trải nghiệm mua sắm và hậu mãi đáng tin cậy.</p>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="about-cards">
                <article class="about-card">
                    <h3>Sứ mệnh</h3>
                    <p>Mang đến những giải pháp nội thất đẹp, sang trọng và có tính ứng dụng cao cho nhiều phong cách sống hiện đại.</p>
                </article>
                <article class="about-card">
                    <h3>Tầm nhìn</h3>
                    <p>Trở thành điểm đến đáng tin cậy cho khách hàng đang tìm kiếm nội thất cao cấp và trải nghiệm tư vấn bài bản.</p>
                </article>
                <article class="about-card">
                    <h3>Cam kết</h3>
                    <p>Luôn ưu tiên chất lượng sản phẩm, tính minh bạch trong tư vấn và sự đồng hành xuyên suốt trước, trong và sau bán hàng.</p>
                </article>
            </aside>
        </section>

        <section class="about-stats">
            <article class="about-stat">
                <strong>500+</strong>
                <span>Sản phẩm nổi bật</span>
                <p>Danh mục đa dạng dành cho phòng khách, phòng ngủ, phòng ăn và decor cao cấp.</p>
            </article>
            <article class="about-stat">
                <strong>100%</strong>
                <span>Tư vấn tận tâm</span>
                <p>Mọi yêu cầu đều được định hướng theo không gian thực tế và nhu cầu sử dụng riêng.</p>
            </article>
            <article class="about-stat">
                <strong>24/7</strong>
                <span>Hỗ trợ nhanh chóng</span>
                <p>Luôn sẵn sàng đồng hành khi khách hàng cần thêm thông tin, tư vấn hoặc đặt hàng.</p>
            </article>
        </section>
    </section>
@endsection
