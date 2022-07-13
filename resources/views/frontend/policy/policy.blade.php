@extends('layouts.frontend.app')

@section('title', 'Refund Policy')

<!-- Content Wrapper -->
@section('content')

<div id="content-wrapper" class="d-flex flex-column premium-news">
    <!-- Main Content -->
    <div id="content">
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="main-news">
          <h1 class="homeheading terms">Refund Policy</h1>
          <div class="premium-newsp">
          <p>At Techshots, our Refund Policy is based on standardized practices that strictly follow industrial norms. We put up with fair assessment practices and all the refund claims are processed with vigilant parameters to make sure the decisions are justified and mutually agreeable. Our policies are treated with appropriate measures to settle different claims, originating from different assortments of needs and various business situations.</p>
          <h5>Coverage & Scope</h5>
          <p>This Refund Policy covers Techshots actions and approaches towards refunds. This Refund Policy does not apply to the practices of companies that Techshots  does not own or control or of persons that we do not employ or manage, including any third-party service and/or product providers bound by contract and any third-party websites to which Techshots websites link.</p>
          <h5>Qualifying For Refunds</h5>
          <p>When you file a complaint to Techshots, we first try to provide an ideal solution to the issue you are facing. Your case is first introduced to the technical team and then reported further to the experts’ panel. A refund is only made in extreme circumstances when nothing good can be done to solve the issue.</p>
          <p>While planning for refunds we check for soundness and validity of the case, applying different conditions to it. If these conditions are satisfied, a refund may apply:</p>
          <ul>
            <li>Development/Post-sales operations have not yet started</li>
            <li>The issues with the project are beyond the scope of rectification/resolution/fixing</li>
            <li>You have not violated our payment terms</li>
            <li>You have not used any information for monetary/business benefits (gained during the course of association)</li>
            <li>The reasons you made are valid/rational/realistic enough to qualify for a refund trial</li>
            <li>You have presented all the proofs and evidence surfacing your refund claim</li>
            <li>The claim does not arise from any billing dispute coming from your bank or payment vendor</li>
          </ul>
          <p>If any of the points mentioned above is found violated, your claim will be considered void. Nodal officer’s decision on refunds is final and irrevocable.</p>
          <h5>Transaction</h5>
          <ul>
            <li>The refund may take 10-30 business days to process after the refund agreement is signed</li>
            <li>You will be refunded in the currency you were charged in. If this is not your native currency, your bank may charge exchange fees, or a change in the exchange rate may have resulted in a difference in the amount refunded compared to the amount you originally paid (in your native currency). It is solely your responsibility if you have to pay any fees or bear any losses in this process.</li>
          </ul>
          <p>Techshots may at any time, without notice to you and in its sole discretion, amend this policy periodically. You are expected to check the policy from time to time for updates. For more information on our Refund Policy, contact us at <a href="mailto:enquiry@techshots.com">enquiry@techshots.com</a>.</p>
          </div>
          
  
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <div class="multiple-bg">
    </div>
    <footer>
        <a class="logo" href="{{route('userdashboard')}}">
            <img src="{{asset('images/logo.svg')}}">
      </a>
      <p> &copy; Techshots Original Content</p>
  
    </footer>
  </div>

@endsection