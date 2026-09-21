<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $answers = [
            1 => 'There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II [here](/membership/articles/article-ii).',
            2 => "The Samahan accepts membership application and/or profile update via a submission online. The online form and submission requirements are available from the link below:\n\n[Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform)",
            4 => 'You may ask the Membership Committee via the following link: [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            6 => 'You may accomplish the query form under "Request for certificate of membership": [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            7 => 'Membership certificates are valid for 72 months (6 years) from the month of issue (except for "lifetime membership"). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws [here](/membership/articles/article-ii) for more details.',
        ];

        foreach ($answers as $sortOrder => $answer) {
            DB::table('membership_faqs')
                ->where('sort_order', $sortOrder)
                ->where('answer', 'not like', '%](%')
                ->update(['answer' => $answer, 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
    }
};
