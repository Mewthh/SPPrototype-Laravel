<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('membership_faqs')->where('sort_order', 2)->update([
            'answer' => "The Samahan accepts membership application and/or profile update via a submission online. The online form and submission requirements are available from the link below:\n\n[Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform)",
            'updated_at' => $now,
        ]);

        DB::table('membership_faqs')->where('sort_order', 4)->update([
            'answer' => 'You may ask the Membership Committee via the following link: [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            'updated_at' => $now,
        ]);

        DB::table('membership_faqs')->where('sort_order', 6)->update([
            'answer' => 'You may accomplish the query form under "Request for certificate of membership": [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
    }
};
