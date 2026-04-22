<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('client.contact.index', [
            'catalogCategories' => $this->catalogCategories(),
            'contactInfo' => [
                'phone' => '0968 498 556',
                'email' => 'aiiuah97@gmail.com',
                'website' => 'http://tathome.com',
            ],
            'consultants' => $this->consultants(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', $this->phoneRule()],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.max' => 'Số điện thoại không đúng định dạng.',
            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
        ]);

        Contact::query()->create([
            'name' => $validated['name'],
            'email' => '',
            'phone' => $this->normalizePhone($validated['phone']),
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('client.contact')
            ->with('status', 'Cảm ơn bạn đã gửi thông tin. Chúng tôi sẽ liên hệ lại sớm.');
    }

    public function quickConsultation(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('footerConsultation', [
            'phone' => ['required', 'string', 'max:20', $this->phoneRule()],
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại để được tư vấn.',
            'phone.max' => 'Số điện thoại không đúng định dạng.',
        ]);

        Contact::query()->create([
            'name' => 'Khách cần tư vấn',
            'email' => '',
            'phone' => $this->normalizePhone($validated['phone']),
            'message' => 'Khách để lại số điện thoại tại footer để được tư vấn miễn phí.',
        ]);

        return back()->with('footer_consultation_status', 'Đã nhận số điện thoại. Chúng tôi sẽ liên hệ tư vấn sớm.');
    }

    private function phoneRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            $phone = $this->normalizePhone((string) $value);

            if (! preg_match('/^(?:0[35789][0-9]{8}|\+84[35789][0-9]{8})$/', $phone)) {
                $fail('Số điện thoại phải đúng định dạng di động Việt Nam, ví dụ 0977665554 hoặc +84977665554.');
            }
        };
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[\s.\-]/', '', trim($phone)) ?? '';
    }

    protected function consultants(): array
    {
        return [
            ['name' => 'Tăng Anh Tuấn', 'image' => asset('images/tun.jpg')],
            ['name' => 'Khổng Lan Hương', 'image' => asset('images/avt2.jpg')],
            ['name' => 'Hoàng Thị Thu', 'image' => asset('images/avt3.jpg')],
            ['name' => 'Nguyễn Quang Linh', 'image' => asset('images/avt4.jpg')],
            ['name' => 'Nguyễn Quang Toàn', 'image' => asset('images/consultants/consultant-5.svg')],
            ['name' => 'Hoàng Thị Thu Thanh', 'image' => asset('images/avt5.png')],
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category>
     */
    protected function catalogCategories()
    {
        return Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();
    }
}
