<!DOCTYPE html>

<head>
    <title>NaukriWala</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/css/uikit.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .footer p{
            margin-top: 20px;
        }
    </style>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher('413ecacd820970cac574', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\MyEvent', function(data) {
            console.log(data)
            alert(JSON.stringify(data));
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit-icons.min.js"></script>
</head>

<body>
    <nav class="uk-navbar-container" uk-navbar>

        <div class="uk-navbar-left">

            <ul class="uk-navbar-nav">
                <li class="uk-active">
                    <a href="#">
                        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo" style="width: 160px;">
                    </a>
                </li>
            </ul>

        </div>

        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li class="uk-active"><a href="{{ url('login') }}">Login</a></li>
            </ul>

        </div>

    </nav>
    <div class="uk-container privacy-policy-new">
        <div class="container" style="text-align:justify">
            <h2>Definitions</h2>
            <ul>
                <li>Subscriber means the customer who is named in the Customer Service Agreement Form and has duly signed
                    it.</li>
                <li>Company means HT Media Limited.</li>
                <li>Services mean access to the resume database and posting of jobs and/or any other product or service
                    offered by the Company to the Subscriber.</li>
                <li>Username mean username provided by the Company to the Subscriber.</li>
                <li>Password mean the password designated to the specified username.</li>
                <li>Third Party mean, any person other the Subscriber who is not party to this arrangement/agreement.</li>
                <li>Website/Network means the Company's portal website naukriwala.co.in for providing Services under this
                    agreement.</li>
                <li>Material Breach mean violation of any terms &amp; condition of the agreement by the Subscriber.</li>
                <li>Tariff Plan refers to the details as mentioned in the rate card for products, services and packages
                    introduced by the Company from time to time for providing the Services as a whole or in part for fixed
                    and/or variable charges.</li>
            </ul>
            <p class="mt-15 mb-0"><strong>Provision of Services:</strong></p>
            <ul class="mt-5">
                <li>After the agreement is entered into by the Subscriber, at the request of the Subscriber, any designated
                    person from Subscriber shall undergo a training to use the Services provided by the Company in relation
                    to the Services opted by the Subscriber.</li>
                <li>The subscriber is required to give KYC documents. In case the same is not provided, the account will be
                    deactivated and no refund shall be made to the subscriber.</li>
                <li>Incase of the account being deactivated due to any technical only and not commercial reason whatsoever
                    at the Company's end; it will credit the Extra hours of usage to the Subscriber's account. However, this
                    option will not be applicable to deactivation of account for non payment or any reason beyond the scope
                    of Company's technical team.</li>
                <li>The Company would not be held liable for any loss of data technical or otherwise, information,
                    particulars supplied by the Subscriber due to the reasons beyond its control like corruption of data as
                    a result of any causes or conditions that are beyond the Company's reasonable control including but not
                    limited to acts of Government, acts of God, Govt. policies, tampering of data by third party like
                    hackers, terrorism or by viruses, trojan horses, trap doors, back doors, easter eggs, worms, time bombs,
                    cancelbots or Computer programming routines that are intended to damage, detrimentally interfere with,
                    surreptitiously intercept or expropriate any system, data or personal information. In no event will the
                    Company be liable for any such direct/indirect /consequential loss or damages, including loss of profit
                    or loss of reputation/defamation, even if advised of the possibility thereof.</li>
                <li>The Company reserves its right to reject any insertion or information/data provided by the Subscriber
                    without assigning any reason whatsoever; either before uploading or after uploading the vacancy details,
                    but in such an eventuality, any amount so paid only for that particular vacancy, shall be refunded to
                    the Subscriber on a pro-rata basis at the sole discretion of the Company except when such rejection is
                    in due to inappropriateness of content , violation of any terms and conditions of this Agreement of
                    usage by the Subscriber.</li>
                <li>The Company has the right to make all necessary modifications/editing of the vacancy details in order to
                    facilitate uploading.</li>
            </ul>
            <h2>Subscribers Obligation</h2>
            <ul class="mb-30">
                <li>All the creative for the package will be designed by Company; however, all the content (logo, pictures,
                    text, etc.) shall be provided by the Subscriber.</li>
                <li>The Subscriber shall by action of signing this agreement issue an implicit &amp; binding warranty to not
                    use/circulate/forward any candidate(s) resume hosted on the Company's website to the candidate (s)
                    current employer as mentioned by the person in his/her resume.</li>
                <li>The information on the Company's website is for use by its Subscribers alone and does not authorize the
                    Subscriber sell/distribute/circulate/forward the data and other information available in the website to
                    any other person, Company and organization for commercial exploitation at the cost of Company.</li>
                <li>The Subscriber shall keep in confidence any information received by the Subscriber under this agreement,
                    irrespective of the business or the matters concerning the other and shall not disclose the same to any
                    third party, save and except to any State or Central Government or to any of their agencies and/or any
                    other concerned legal and other competent authorities on specific demand or under a general obligation.
                </li>
                <li>The Subscriber represents, warrants &amp; assures that the data provided by the Subscriber in terms of
                    this Agreement for uploading/posting shall not contain any viruses, trojan horses, trap doors, back
                    doors, easter eggs, worms, time bombs, cancelbots or other computer programming routines that are
                    intended to damage, detrimentally interfere with, surreptitiously intercept or expropriate any system,
                    data or personal information in the event of detection of which the Company will reserve the right to
                    cancel the agreement ab initio and forefeit the consideration exchanged so for the purpose of this
                    agreement. This will be apart from the right of the Company to take appropriate legal action, if
                    required.</li>
                <li>The data provided by the Subscriber shall be deemed to have been voluntarily supplied, non-confidential
                    and the Subscriber hereby discharges the Company of all obligations of confidentiality.</li>
                <li>The Subscriber further represents and warrants &amp; assures that, the data provided by the Subscriber
                    for the purpose of uploading in the Website, shall not be violative of any IPR, rights of privacy,
                    rights of publicity and/or any other rights of third party and shall not be violative of any provision
                    of Law in force. </li>
                <li>The Subscriber represents, warrants and assures that data provided by the Subscriber for the purpose of
                    uploading on the Website, shall not be fake or incorrect or inappropriate and that he shall ensure
                    responsible use of the Services. Without prejudice to what is stated under point 2.4 and notwithstanding
                    anything contained under point 2.5, Subscriber further represents and warrants that he shall be solely
                    responsible for the correctness of the data provided by him and in case of any third party action in
                    this regard, the Subscriber shall indemnify and hold the Company harmless. Subscriber also understands
                    that in case more than ten postings in a day provided by the Subscriber are not approved for going live
                    on site by the Company then the same will be deemed as a case of misuse of Services by the Subscriber
                    and the Company shall have the right to refuse /revoke its Services in such a case and/or terminate the
                    Services and/or take appropriate legal action against the Subscriber.</li>
                <li>In case by misrepresentation or false postings the Subscriber takes away the data which is the
                    intellectual property of the Company, then in addition to the rights available to the Company herein,
                    the Company shall have the right to initiate appropriate legal action against the Subscriber.</li>
                <li>By action of signing this agreement, the Subscriber agrees to use of information, materials, logos and
                    or data as supplied by it, in any form or medium, including without limitation the internet and print by
                    the Company for the purpose of this agreement including but not limited to use of such information,
                    material, logos and or data on Company's home page, and its publications.</li>
            </ul>
            <p class="mb-0"><strong>Termination: The Company may terminate the Services in case the
                    Subscriber:</strong></p>
            <ul class="mb-30 mt-5">
                <li>Commits any breach of these terms and condition, representation &amp; warranties and Subscribers
                    obligations as contemplated in this agreement.</li>
                <li>Fails to make payments as per the terms &amp; condition herein.</li>
                <li>Uses the Services provided by the Company for any illegal, unlawful or immoral purposes or in any
                    fraudulent manner or for purposes not authorized by the Company.</li>
                <li>The Subscriber shall keep in confidence any information received by the Subscriber under this agreement,
                    irrespective of the business or the matters concerning the other and shall not disclose the same to any
                    third party, save and except to any State or Central Government or to any of their agencies and/or any
                    other concerned legal and other competent authorities on specific demand or under a general obligation.
                </li>
                <li>Advice received from regulatory or any other competent authorities.</li>
                <li>Commits violation of any IPR, rights of privacy, rights of publicity and/or any other rights of third
                    party and shall not be violative of any provision of Law in force. </li>
            </ul>
            <p class="mb-0"><strong>General Terms &amp; Condition:</strong></p>
            <ul class="mb-30 mt-5">
                <li>These job postings may not be substituted with other job postings during this term without incurring
                    additional charges. Any jobs posted by Subscriber on the website and in excess of the number of jobs
                    provided for in this Agreement will be billed to the Subscriber and shall be payable by the Subscriber
                    in accordance with the terms hereof, at the Company's then prevailing rate for such job postings on the
                    Website.</li>
                <li>The Company may, in its sole discretion, impose a interest equal to 18% per month on all overdue
                    accounts.</li>
                <li>Any re activation of a deleted or expired job posting and any refreshing of any job posting constitutes
                    use of an additional job posting hereunder.</li>
                <li>Website's resume database (each a "Resume Database") is a private database for use by Subscriber's only.
                    A Subscriber is defined as one unique user with one unique password provided by the Company. If the
                    Subscriber (including its employees or consultants) is found to share passwords with any third party,
                    the Company may revoke all passwords forthwith and no refund will be given.</li>
                <li>The Subscriber agrees to notify the Company promptly after the departure of any person to whom a
                    password was provided and the Company shall on such intimation issue a new password to the Subscriber.
                    The Company reserves the right to periodically change issued passwords with prior notice only to
                    identified hierarchy head for security reason. However changed password shall be informed to the
                    Subscriber immediately.</li>
                <li>The charges paid by the Subscriber to the Company under this Agreement are non-refundable. The website
                    (including without limitation all data therein), and all elements, which are a part of the foregoing,
                    and all intellectual and other proprietary rights therein, are the property of the Company. Neither the
                    Subscriber nor any of its employees shall do anything, which would in any way damage, injure or impair
                    the validity of the Company's rights in the contents of the website. Notwithstanding the above, any data
                    placed on the website by the Subscriber herein, and all elements which are a part of the such data, and
                    all intellectual and other proprietary rights therein, are and shall at all times remain the
                    Subscriber's property.</li>
                <li>To the extent permitted by law the Company makes no warranties, express or implied, including the
                    warranties of merchantability, fitness for a particular purpose, or non-infringement with respect to its
                    services or the website, or results of use thereon and all warranties and conditions, express or implied
                    are hereby excluded.</li>
                <li>Subscriber agree to indemnify the Company, its officers, directors, employees and agents, from and
                    against any claims, actions or demands, including without limitation reasonable legal and accounting
                    fees, arising or resulting from its breach of this Agreement or breach of representation and warranties
                    as contemplated herein or from its provision of any material to the website, including but not limited
                    to claims of breach of any third party rights including intellectual property rights or breach of any
                    provision of any law for time being in force. </li>
                <li>Notwithstanding anything to the contrary contained herein, except as may arise under the immediately
                    preceding paragraph, neither party will be liable to the other party (nor to any person claiming rights
                    derived from the other party's rights) for incidental, indirect, consequential, special, punitive or
                    exemplary damages of any kind including lost revenues or profits, loss of business or loss of data
                    arising out of this agreement (including without limitation as a result of any breach of any warranty,
                    or other term of this agreement), regardless of whether the party liable or allegedly liable was
                    advised, had other reason to know, or in fact knew of the possibility thereof. Moreover, the Company's
                    maximum liability arising out of or relating to the transaction, which is the subject matter of this
                    agreement, regardless of the cause of action (whether in contract, tort, breach of warranty or
                    otherwise), will not exceed the amount paid by the Subscriber to HT Media Limited hereunder minus any
                    necessary service charges or taxation already incurred by the Company.</li>
                <li>Notwithstanding anything to the contrary contained herein, the Subscriber's use of the website is
                    subject to the Terms of Use/Private Policy/Disclaimer available from such website's homepage. By
                    Subscriber's execution hereof it hereby agrees to abide by such Terms of Use/Private Policy/Disclaimer,
                    as they may be amended from time to time.</li>
                <li>This Agreement (i) constitutes the entire Agreement between the parties with respect to the subject
                    matter hereof and supersedes any previous oral or written arrangements or understandings relating
                    thereto; (ii) may be signed in counterparts, (iii) may not be amended, terminated or waived orally, (iv)
                    may not be assigned, in whole or in part, directly or indirectly, or otherwise, by the Subscriber and
                    only comes into existence when signed by its authorized signatory and (v) Company shall not be
                    responsible for unauthorized access to data by third parties, or data lost whether or not arising during
                    operation or transmission as a result of server functions, virus, bugs or other causes beyond its
                    control. The Company will be entitled to assign all or any of its rights and obligations hereunder to
                    any third party.</li>
                <li>Any terms of this Agreement that may be invalid shall not affect the validity of enforcement of the
                    remaining valid terms of this Agreement. The terms and conditions of this Agreement may not be amended
                    without the affirmative written consent of HT Media Limited.</li>
                <li>The Company shall address all billing statements/notices/correspondence under this Agreement to the
                    address given in the page no. 1 of this Customer Service Agreement Form. The Subscriber shall inform the
                    Company in writing of any changes in the address immediately and obtain an acknowledgement to such
                    effect.</li>
                <li>The Company reserves the right to recover/charge any amounts to the Subscriber on account of any taxes
                    levied by the Central/State Govt. on the services as contemplated in this agreement from time to time
                    and which are not included in the total payment consideration received by the Company.</li>
                <li>The subscriber is mandatorily required to have a GSTIN number in compliance with the law.</li>
                <li>The Company shall not refund or give a credit note or charge additional charges to the Subscriber in the
                    event of change in the tariff plans which the Company may introduce from time to time.</li>
            </ul>
            <p class="mb-0"><strong>Terms of agreement:</strong></p>
            <ul class="mb-30 mt-5">
                <li>The agreement shall be effective for the period as specified in the Customer Service Agreement Form.
                    This agreement will be extended automatically for a further period of similar duration, unless otherwise
                    specified or terminated by the Company or by the Subscriber through a written communication to the
                    Company seeking withdrawal of services on or before atleast 1 week from the date of expiry of the
                    agreement. The Company will accordingly raise an invoice basis the prices of services prevailing at the
                    time of extension/renewal of this agreement and all other terms and conditions of the agreement shall
                    remain unchanged.</li>
            </ul>
            <p class="mb-0"><strong>Governing Law:</strong></p>
            <ul class="mb-30 mt-5">
                <li>The Terms &amp; Conditions between the Subscriber &amp; the Company shall be governed by the laws of
                    India and any dispute or differences, if any between the Subscriber &amp; the Company, shall be subject
                    to the exclusive jurisdictions of the Courts in Delhi alone.</li>
            </ul>
            <h2>SmartSearch -Terms and Conditions</h2>
            <p class="mb-5 mt-15"><strong>CDA</strong></p>
            <ul class="mb-30 mt-5">
                <li>HTML agrees to provide the service to the subscriber only for the duration contracted for to the best of
                    its ability.</li>
                <li>HTML reserves the right to suspend/terminate the services contracted for by the subscriber either prior
                    to or during the contracted period without assigning any reason.</li>
                <li>The subscriber shall be entitled to 3 user names /passwords to access the CDA service alone and
                    additional user names /passwords may be provided by HTML on such terms and conditions as may be mutually
                    agreed upon.</li>
                <li>HTML offers no guarantee nor warranties that there would be a satisfactory response or any response at
                    all subscriber for applications received using the CDA software.</li>
                <li>HTML shall in no way be held liable for any information received by the subscriber and it shall be the
                    sole responsibility of the subscriber to check, authenticate and verify the information/response
                    received at its own cost and expense.</li>
                <li>HTML would not be held liable for any loss of data technical or otherwise, information, particulars
                    supplied by the customers due to the reasons beyond its control like corruption of data or delay or
                    failure to perform as a result of any causes or conditions that are beyond HTML's reasonable control
                    including but not limited to strike, riots, civil unrest, Govt. policies, tampering of data by
                    unauthorized persons like hackers, war and natural calamities.</li>
                <li>HTML will commence providing services only upon receipt of charges upfront either from the subscriber or
                    from a third party on behalf of the subscriber.</li>
                <li>The subscriber/Recruiter shall give an undertaking to HTML that the jobs sought to be filled through
                    naukriwala.co.in are in existence, genuine and the subscriber has the authority to recruit /advertise for such
                    vacancies. Also the subscriber undertakes that the database will be used to contact candidates for jobs
                    only.</li>
                <li>The subscriber/Recruiter must give an undertaking to HTML that there will be no fee charged from any
                    person who is contacted through CDA for processing of such person.</li>
                <li>This subscription is neither re-saleable nor transferable by the subscriber to any other person,
                    corporate body, firm or individual concern.</li>
                <li>The subscriber shall be assigned a password (s) by HTML to enable the subscriber to access all the
                    information received through the software, but the sole responsibility of the safe custody of the
                    password shall be that of the subscriber and HTML shall not be responsible for data loss/theft of
                    data/corruption of data or the wrong usage/misuse of the password and any damage or leak of information
                    and its consequential usage by a third party. HTML undertakes to take all reasonable precautions at its
                    end to ensure that there is no leakage/misuse of the password granted to the subscriber.</li>
                <li>The information on Naukriwala CDA is for use by its subscribers alone and does not authorize the subscriber
                    to download and use the data for commercial purposes. In case anyone is found to be in violation of this
                    then HTML at its discretion may suspend its service/subscription and also may take such action as it may
                    be advised.</li>
                <li>The subscriber shall not use /circulate /forward a person's resume hosted on the Naukriwala Network /Resumes
                    to his /her current employer as mentioned by the person in his /her resume.</li>
                <li>The User of these services does not claim any copyright or other Intellectual Property Right over the
                    data uploaded by him or on his behalf on the website or supplied to HTML.</li>
                <li>All Disputes arising out of the transactions between a user and HTML will be subject to the jurisdiction
                    of Courts situate in Delhi alone. CDA: Naukriwala resume database from where all resumes can be accessed</li>
            </ul>
            <h2>Anti-Spam POLICY</h2>
            <ul class="mb-30">
                <li>The use and access to CDA database is subject to this policy. The services provided to you are aimed at
                    providing recruitment solutions and should be restricted to contacting suitable candidates for genuine
                    jobs in existence. Mailing practices such as transmitting marketing and promotional mailers/Offensive
                    messages/messages with misleading subject lines in order to intentionally obfuscate the original
                    message, are strictly prohibited. We reserve the right to terminate services, without prior notice, to
                    the originator of Spam. No refund shall be admissible under such circumstances.</li>
                <li>Following is an illustrative (not exhaustive) list of the kinds of messages which can be classified as
                    spam:</li>
                <li>Unsolicited Bulk Messages/Unsolicited Commercial Messages.</li>
                <li>Non Job related mails.</li>
                <li>Messages with misleading subject lines.</li>
                <li>Blank Messages.</li>
                <li>Extra ordinary High Number of mails.</li>
                <li>Mails soliciting payments.</li>
                <li>Misleading/Fraudulent mails.</li>
                <li>Users agree to indemnify and hold harmless HTML from any damages or claims arising out of usage of their
                    CDA accounts for transmitting spam.</li>
                <li>Users are advised to change their passwords frequently in order to reduce the possibility of misuse of
                    their accounts.</li>
                <li>To seek more information and to report Spam. Please mail us at: abuse@naukriwala.co.in</li>
            </ul>
            <p class="mb-5"><strong>"Post 2 Jobs at Rs 999" - Terms &amp; Conditions:</strong></p>
            <ul class="mb-30 mt-5">
                <li>This pack will be applicable for a period of 30 days</li>
                <li>These terms and conditions are applicable to those who decide to avail the offer "Post jobs at Rs 999 on
                    naukriwala.co.in" a special job posting campaign/offer for the recruiters, offered by naukriwala.co.in, a job portal
                    of HT Media Limited (hereinafter referred to as "HTML"). By signing the following Terms, you will be
                    deemed have accepted the terms and conditions as provided herein. You agree to be bound by these Terms
                    and Conditions or any subsequent future amendments thereof. HTML reserves the right, in its sole
                    discretion, to amend or revise these terms and conditions at any point of time, without prior notice and
                    you agree to be bound by such amendments or revisions. The information provided by you while availing
                    our services, you consent to the use, transfer and storage of the information so provided by you, on our
                    servers.</li>
                <li>The recruiter agree that they shall provide complete KYC as per the standard norms laid down by the
                    company within 2 working days of purchasing the package i.e GSTIN Certificate, registered company's Pan
                    Card, registered company's certification of incorporation, registered contact person Aadhaar Card (copy
                    of both sides), registered contact person Pan Card. All documents should be self attested. In case your
                    Company is a proprietorship or partnership Firm, we require company address proof like: electricity
                    bill, telephone bill (Airtel or BSNL postpaid bills or landline bill), registration by municipality or
                    office registration copy etc. In case you are a freelancer, freelancer's Pan Card and Aadhar Card (copy
                    of both sides self attested) will be acceptable.</li>
                <li>The recruiter acknowledges and agrees that if the document is not provided within 2 working days, the
                    recruiter account will be suspended till the KYC documents are submitted deactivated and</li>
                <li>This package is non refundable , and hence if the account is suspended or deactivated due to non
                    submission of KYC or violation of the Terms and Use, the amount shall not be refunded.</li>
                <li>The recruiters agree that Naukriwala reserves the right to terminate the account post activation of account
                    if the documents are found to be fake and during the course of verification</li>
                <li>The recruiter shall be bound by the terms and conditions available at
                    https://recruiter.naukriwala.co.in/termsandconditions/ and shall be governed by the privacy policy at
                    https://naukriwala.co.in/privacypolicy/</li>
                <li>The information provided by you shall be used by us, including but not limited, to:</li>
                <ul>
                    <li>Improve our website and enable us to provide you the most user-friendly experience which is safe,
                        smooth and customized;</li>
                    <li>Improve and customize our services, content and other commercial /non - commercial features on the
                        website;</li>
                    <li>Send you information on our products, services, special deals, promotions;</li>
                    <li>Send you service-related announcements on rare occasions when it is necessary to do so; provide you
                        the opportunity to participate in contests or surveys on our website (If you participate, we may
                        request certain additional personally identifiable information from you. Moreover, participation in
                        these surveys or contests shall be completely voluntary and you therefore shall have a choice
                        whether or not to disclose such additional information);</li>
                    <li>Resolve disputes, if any and troubleshooting;</li>
                    <li>Avoid/check illegal and/or potentially prohibited activities and to enforce Agreements;</li>
                    <li>Provide service updates and promotional offers related to our services/products.</li>
                    <li>Comply with any court judgment / decree / order / directive / legal &amp; government authority
                        /applicable law;</li>
                    <li>Investigate potential violations or applicable national &amp; international laws;</li>
                    <li>Investigate deliberate damage to the website/services or its legitimate operation;</li>
                    <li>Detect, prevent, or otherwise address security and/or technical issues;</li>
                    <li>Protect the rights, property or safety of HTML and/or its Directors, employees and the general
                        public at large; and</li>
                    <li>Respond to claims of third parties;</li>
                    <li>To carry out our own analysis and research.</li>
                </ul>
            </ul>
            <h2>Account Protection</h2>
            <ul class="mb-30">
                <li>Your password is the key to your account. You shall be solely responsible for all the activities
                    happening under your username and you shall be solely responsible for keeping your password secure. Do
                    not disclose your password to anyone. If you share your password or your personal information with
                    others, you shall be solely responsible for all actions taken under your username and you may lose
                    substantial control over your personal information and may be subject to legally binding actions taken
                    on your behalf. Therefore, if your password has been compromised for any reason, you should immediately
                    change your password. Business Transaction</li>
                <li>In the event HTML goes through a business transition, such as a merger, acquisition by another company,
                    or sale of all or a portion of its assets, your personally identifiable information will likely be among
                    the assets transferred. Where your information is transferred you will be notified via email/prominent
                    notice on our website for 30 days of any such change in ownership or control of your personal
                    information.</li>
                <li>The security of your personal information is important to us. When you enter your personal information
                    we treat the data as an asset that must be protected and use tools (encryption, passwords, physical
                    security etc.) to protect the information provided by you against unauthorized access and disclosure.
                    However, no method of transmission over the Internet, or method of electronic storage, is 100% secure,
                    therefore, while we strive to use commercially acceptable means to protect all the information provided
                    by you, we cannot guarantee its absolute security nor can we guarantee that third parties shall not
                    unlawfully intercept or access transmissions or private communications, and that other users may abuse
                    or misuse the information that you provide. Therefore, although we work hard to protect your
                    information, we do not promise, and you should not expect, that your personal information or private
                    communications will always remain private.</li>
            </ul>
            <h2>General Terms</h2>
            <ul>
                <li>HTML reserves the right to disqualify any recruiter if it has reasonable grounds to believe the
                    recruiter has breached any of these Terms and Conditions.</li>
                <li>The Contest shall be governed by and construed in accordance with the laws of India.</li>
                <li>The recruiter further agrees that HTML cannot be made responsible for any damage, loss, injury or
                    disappointment suffered by it as a result of its deciding to avail the services as offered by HTML
                    herein.</li>
                <li>The recruiter undertakes to indemnify HTML for any claims or damages arising from HTML's posting of jobs
                    on account of the recruiter following consent of the recruiter.</li>
                <li>These Terms and Conditions shall be governed by and construed in accordance with the laws of India. Any
                    disputes, differences and, or, any other matters in relation to and arising out of the campaign "Post a
                    job at Rs 999 on naukriwala.co.in" and, or the Terms and Conditions thereof the same shall be referred to
                    arbitration under the Arbitration &amp; Conciliation Act, 1996. The arbitral tribunal shall consist of a
                    sole arbitrator to be appointed by HTML. The venue of arbitration shall be New Delhi and the proceedings
                    of such arbitration shall be in English Language only.</li>
                <li>All disputes shall be subject to the exclusive jurisdiction of Delhi Courts only.</li>
                <li>These Terms &amp; Conditions are the complete and exclusive statements of the understanding between HTML
                    &amp; the recruiter. It supersedes all the understanding or other prior understanding, whether oral
                    &amp; written, and all representation or other communications between HTML &amp; the recruiter.</li>
            </ul>
        </div>
    </div>
    <div class="footer uk-container">
        <p class="uk-float-left"> <a href="{{ route('privacy.policy')}}">Privacy Policy</a></p>
        <p class="uk-clearfix uk-float-right">
            <span class="uk-float-md-left uk-d-block uk-d-md-inline-block uk-mt-25">COPYRIGHT &copy; <script>document.write(new Date().getFullYear())</script><a class="ml-25" href="#" target="_blank">NaukriWala</a>
              <span class="uk-d-none uk-d-sm-inline-block">, All rights Reserved</span>
            </span>
        </p>
    </div>
</body>
