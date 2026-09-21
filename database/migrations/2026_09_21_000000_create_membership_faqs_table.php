<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question', 1000);
            $table->text('answer');
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['is_visible', 'sort_order']);
        });

        $now = now();
        DB::table('membership_faqs')->insert([
            ['question' => 'What are the types of membership in Samahang Pisika ng Pilipinas (SPP, or Samahan)?', 'answer' => 'There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II [here](/membership/articles/article-ii).', 'is_visible' => true, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'How do I apply for membership to the Samahan?', 'answer' => 'The Samahan accepts membership application and/or profile update via an online submission. The online form and submission requirements are available from the link below: [Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform).', 'is_visible' => true, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'Is there an application fee to be paid as a new member?', 'answer' => 'No. Once your application is approved you are required to attend the SPP National Physics Congress to take an oath of membership and pay annual membership dues. However, your annual membership fee is waived if you have paid conference fees to attend the SPP Congress in the same year.', 'is_visible' => true, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'How do I know my membership status in the Samahan?', 'answer' => 'You may ask the Membership Committee via the following link: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).', 'is_visible' => true, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'How is the membership fee paid in the Samahan?', 'answer' => 'In the past few years, the Membership Fee for a given year is deemed paid every time you attend the annual SPP National Physics Congress. The membership fee is waived for members who pay for the conference fee that year.', 'is_visible' => true, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'How do I request for a membership certificate?', 'answer' => 'You may accomplish the query form under “Request for certificate of membership”: [Membership Inquiry Form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).', 'is_visible' => true, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'When does a membership certificate lose validity?', 'answer' => 'Membership certificates are valid for 72 months (6 years) from the month of issue (except for “lifetime membership”). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws [here](/membership/articles/article-ii) for more details.', 'is_visible' => true, 'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_faqs');
    }
};
