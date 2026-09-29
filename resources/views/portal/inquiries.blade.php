<x-layouts.portal title="Inquiries | SPP Membership Portal">
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">Support</p>
            <h1>Inquiries</h1>
        </div>
    </div>

    <section class="portal-card">
        <h2>Submit Inquiry</h2>
        <form class="portal-form" onsubmit="return false;">
            <label>
                Query Type
                <select>
                    <option>Application Status</option>
                    <option>Membership Status</option>
                    <option>Request for Certificate of Membership</option>
                    <option>Other</option>
                </select>
            </label>
            <label class="portal-form-wide">
                Remarks
                <textarea rows="4" placeholder="Describe your inquiry or concern..."></textarea>
            </label>
            <div class="portal-form-wide">
                <button type="submit" class="portal-button">Submit Inquiry</button>
            </div>
        </form>
    </section>

    <section class="portal-card">
        <div class="portal-section-heading">
            <h2>Inquiry History</h2>
        </div>
        <div class="portal-table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Query Type</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Application Status</td>
                        <td>MM/DD/YYYY</td>
                        <td><x-portal.status-badge status="Submitted" /></td>
                    </tr>
                    <tr>
                        <td>Membership Status</td>
                        <td>MM/DD/YYYY</td>
                        <td><x-portal.status-badge status="Under Review" /></td>
                    </tr>
                    <tr>
                        <td>Request for Certificate of Membership</td>
                        <td>MM/DD/YYYY</td>
                        <td><x-portal.status-badge status="Responded" /></td>
                    </tr>
                    <tr>
                        <td>Other</td>
                        <td>MM/DD/YYYY</td>
                        <td><x-portal.status-badge status="Closed" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.portal>
