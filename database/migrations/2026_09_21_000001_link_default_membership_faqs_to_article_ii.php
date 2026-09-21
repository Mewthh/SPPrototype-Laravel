<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'How do I apply for membership to the Samahan?' => ['The Samahan accepts membership applications and profile updates through its online submission form.', 'The Samahan accepts membership application and/or profile update via an online submission. The online form and submission requirements are available from the link below: [Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform).'],
            'How do I know my membership status in the Samahan?' => ['You may ask the Membership Committee through the Membership Inquiry Form.', 'You may ask the Membership Committee via the following link: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).'],
            'How do I request a membership certificate?' => ['You may submit a request through the Membership Inquiry Form.', 'You may accomplish the query form under “Request for certificate of membership”: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).'],
        ];

        foreach ($defaults as $question => [$previousAnswer, $answer]) {
            DB::table('membership_faqs')->where('question', $question)->where('answer', $previousAnswer)->update(['answer' => $answer, 'updated_at' => now()]);
        }

        DB::table('membership_faqs')
            ->where('question', 'What are the types of membership in Samahang Pisika ng Pilipinas (SPP, or Samahan)?')
            ->where('answer', 'There are three basic types of membership in SPP: Associate member, Regular member, and Institutional member.')
            ->update(['answer' => 'There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II [here](/membership/articles/article-ii).', 'updated_at' => now()]);

        DB::table('membership_faqs')
            ->where('question', 'When does a membership certificate lose validity?')
            ->where('answer', 'Membership certificates are valid for 72 months (6 years) from the month of issue, except for lifetime membership.')
            ->update(['answer' => 'Membership certificates are valid for 72 months (6 years) from the month of issue (except for “lifetime membership”). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws [here](/membership/articles/article-ii) for more details.', 'updated_at' => now()]);
    }

    public function down(): void
    {
    }
};
