<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class MembershipArticleController extends Controller
{
    public function show(string $slug): View
    {
        abort_unless($slug === 'article-ii', 404);

        $articleIIContent = <<<'MARKDOWN'
**1.) Election to Membership**
a) The National Council elects the new Regular, Associate, Fellow, Honorary and Institutional Members based on the recommendation of its Membership Committee.
b) The Membership Committee screens Regular, Associate and Institutional membership applications and, if necessary, investigates the veracity of the submitted documents.
c) The National Council can promote Associate Members to Regular Membership upon the recommendation of the Membership Committee.
d) The Awards and Nominations Committee nominates Fellows and Honorary Members.

**2.) Qualifications for Regular Members**
a) A Ph.D. degree in Physics or allied fields (e.g., Engineering) is a minimum requirement.
b) In exceptional circumstances, an MS degree in Physics or allied fields and publications in physics or allied fields in reputable journals or consistent presentation of SPP papers (5-year minimum) in Annual Congresses may count as an equivalent.

**3.) Qualifications for Institutional Members**
a) Organizations, foundations, institutions and corporations can become institutional members by paying an annual fee prescribed by the National Council or by making an equivalent donation.
b) Institutional membership has no bearing on the membership of the individual members of the organization, foundation, institution or corporation to the Samahan.

**4.) Duties of Members**
a) All members are expected to uphold the spirit, dignity and integrity of the SPP as a professional organization.
b) All members, except honorary members and fellows, are expected to pay the annual membership fee.
c) All members are to serve in committees when called upon by the National Council.

**5.) Rights and Privileges of Members**
a) All members are entitled to receive information about the SPP activities.
b) All members are entitled to member rates when attending the National Physics Congress.
c) All members are entitled to discounts to SPP publications.
d) Honorary members and Fellows automatically receive lifetime membership to the SPP.
e) Regular and Associate Members are entitled to cast their vote during the election of officers of the Samahan and in appropriate decision making processes during business meetings.
f) Institutional Members can send their duly designated representative to observe or participate in the National Physics Congress gratis or relay any special concerns to the National Council.
g) Honorary members, Fellows and Institutional members are entitled to additional benefits as stipulated by the National Council.

**6.) Oath-of Membership**
a) All new Regular and Associate members are required to take the oath of membership before their membership takes effect.
b) The oath of membership is usually administered during the National Physics Congress.
c) Only the President, First Vice President and Second Vice President are allowed to administer the oath of membership.
d) In case of the unavailability of the officers mentioned above, the National Council can assign any of its members to administer the oath of membership.

**7.) Inactive Membership**
a) Members who fail to pay the membership fee for the membership year will be considered inactive.
b) During the fifth year of inactivity, a member will be given notice by the Secretariat. If the inactive member fails to update his/her membership, he/she will be dropped from the list of SPP members.
c) Reactivation of membership is automatically achieved by paying the annual membership fee. In cases where the member has been dropped from the list, the former member has to apply as a new member.

**8.) Suspension or Expulsion from the Samahan**
a) Members who fail to uphold the spirit, dignity and integrity of the SPP as a professional organization can be suspended or expelled from the Samahan by the National Council.
b) Complaints against members duly endorsed by the complainant can be filed with the National Council for appropriate action.

**9.) Promotion**
a) Promotion from associate to regular membership will be considered upon presentation of documents (updated curriculum vitae, publications, certificates) indicating satisfaction of membership requirements.
b) Nominations for Honorary Membership or Fellowship can be submitted to the Awards and Nominations Committee with supporting documents.
MARKDOWN;

        $article = Page::query()->firstOrCreate(
            ['slug' => 'article-ii'],
            ['title' => 'Article II: Membership', 'content' => $articleIIContent, 'status' => 'published'],
        );

        $article->update(['content' => $articleIIContent, 'title' => 'Article II: Membership']);

        return view('membership-article', ['article' => $article]);
    }
}
