<x-layouts.portal title="My Application | SPP Membership Portal">
    <div class="portal-page-header"><div><p class="portal-eyebrow">Application</p><h1>My Application</h1></div><x-portal.status-badge status="Under Evaluation" /></div>

    <section class="portal-card"><div class="portal-section-heading"><h2>Application Flow</h2></div><x-portal.timeline :steps="['Membership Type', 'Recommender', 'Member Information', 'Documents', 'Validation / Certification', 'Review & Submit']" :current="5" /></section>

    <div class="portal-information-grid">
        <x-portal.info-card title="Membership Information"><div><dt>Membership Type</dt><dd>Regular Member</dd></div><div><dt>Application Type</dt><dd>Sample Application</dd></div><div><dt>Application Date</dt><dd>MM/DD/YYYY</dd></div><div><dt>Application Status</dt><dd><x-portal.status-badge status="Under Evaluation" /></dd></div></x-portal.info-card>
        <x-portal.info-card title="Recommender"><div><dt>Name</dt><dd>Sample Name</dd></div><div><dt>Email</dt><dd>example@email.com</dd></div><div><dt>Suffix</dt><dd>Sample</dd></div><div><dt>Alternate Recommender</dt><dd>Sample Name</dd></div><div><dt>Recommender Status</dt><dd><x-portal.status-badge status="Pending" /></dd></div></x-portal.info-card>
        <x-portal.info-card title="Personal Information"><div><dt>Surname</dt><dd>Sample</dd></div><div><dt>First Name(s)</dt><dd>Sample Name</dd></div><div><dt>Middle Name(s)</dt><dd>Sample</dd></div><div><dt>Mobile Number</dt><dd>Sample</dd></div><div><dt>Email Address</dt><dd>example@email.com</dd></div></x-portal.info-card>
        <x-portal.info-card title="Professional Information"><div><dt>Current Institutional Affiliation</dt><dd>Sample Institution</dd></div><div><dt>Current Position</dt><dd>Sample</dd></div><div><dt>Professional / Institutional Email</dt><dd>example@email.com</dd></div></x-portal.info-card>
        <x-portal.info-card title="Educational Information"><div><dt>Highest Educational Attainment</dt><dd>Sample</dd></div><div><dt>Degree</dt><dd>Sample</dd></div><div><dt>Date Degree Obtained</dt><dd>MM/DD/YYYY</dd></div><div><dt>Institution</dt><dd>Sample Institution</dd></div><div><dt>Institution Address</dt><dd>Sample</dd></div></x-portal.info-card>
        <section class="portal-card portal-info-card"><h2>Documents</h2><x-portal.document-row label="Updated CV" /><x-portal.document-row label="Proof of Employment / Enrollment" /></section>
        <x-portal.info-card title="Validation / Certification"><div><dt>Declaration</dt><dd>Agreed</dd></div><div><dt>Certification</dt><dd>Confirmed</dd></div></x-portal.info-card>
    </div>
</x-layouts.portal>
