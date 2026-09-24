<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $answers = [
            1 => 'There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II [here](/membership/articles/article-ii).',
            2 => 'The Samahan accepts membership application and/or profile update via a submission online. The online form and submission requirements are available from the link below:\n\n[Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform)',
            3 => 'No. Once your application is approved you are required to attend the SPP National Physics Congress to take an oath of membership and pay annual membership dues. However, your annual membership fee is waived if you have paid conference fees to attend the SPP Congress in the same year.',
            4 => 'You may ask the Membership Committee via the following link: [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            5 => 'In the past few years, the Membership Fee for a given year is deemed paid every time you attend the annual SPP National Physics Congress. The membership fee is waived for members who pay for the conference fee that year.',
            6 => 'You may accomplish the query form under "Request for certificate of membership": [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            7 => 'Membership certificates are valid for 72 months (6 years) from the month of issue (except for "lifetime membership"). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws [here](/membership/articles/article-ii) for more details.',
        ];

        foreach ($answers as $sortOrder => $answer) {
            DB::table('membership_faqs')
                ->where('sort_order', $sortOrder)
                ->where('created_at', '<=', now())
                ->whereIn('answer', $this->defaultAnswerVariants($sortOrder))
                ->update(['answer' => $answer, 'updated_at' => now()]);
        }
    }

    /** @return list<string> */
    private function defaultAnswerVariants(int $sortOrder): array
    {
        return match ($sortOrder) {
            2 => ['The Samahan accepts membership applications and profile updates through its online submission form.', 'The Samahan accepts membership application and/or profile update via an online submission. The online form and submission requirements are available from the link below: [Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform).'],
            4 => ['You may ask the Membership Committee through the Membership Inquiry Form.', 'You may ask the Membership Committee via the following link: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).'],
            6 => ['You may submit a request through the Membership Inquiry Form.', 'You may accomplish the query form under “Request for certificate of membership”: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).'],
            default => [],
        };
    }

    public function down(): void {}
};
