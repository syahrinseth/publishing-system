<html style="page-break-after: always;">
<head>
  <style>
    /* Your CSS styles go here */
    body {
        margin-top: 20pt;
        margin-left: 72pt;
        margin-right: 72pt;
        margin-bottom: 20pt;
    }
    .title {
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
    }

    .authors {
      font-size: 18px;
      text-align: center;
      margin-bottom: 20px;
    }

    .institution {
      font-size: 16px;
      text-align: center;
      margin-bottom: 20px;
    }

    .abstract {
      font-size: 14px;
      text-align: justify;
      margin-bottom: 20px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .keywords {
      font-size: 14px;
      text-align: justify;
      margin-bottom: 20px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .journal-name {
      font-size: 12px;
      text-align: left;
      margin-bottom: 20px;
    }

    .page-number {
        font-size: 12px;
        text-align: right;
        margin-bottom: 20px;
    }

    .row {
        width: 100%;;
    }

    .w-full {
        width: 100%;
    }

    .w-50 {
      width: 50%;
    }

    .w-25 {
      width: 25%;
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        border-top: 0.2px grey solid;
        text-align: right;
        line-height: 50px;
    }

    .copyright {
        font-size: 12px;
        text-align: right;
    }

    .border-none {
        border: none;
    }

    .text-right {
      text-align: right;
    }

    /** Define the header rules **/
    header {
            /* position: fixed; */
            padding-left: 20px;
            padding-right: 20px;
            margin-bottom: 50px;
        }

  </style>
</head>
<body>
    <!-- Your HTML goes here -->
    <header class="">
        <table class="w-full border-none">
          <tr>
              <td class="w-50 border-none">
                {{ config('app.name') }}
              </td>
              <td class="w-25 text-right border-none">
                1
              </td>
          </tr>
            
      </table>
    </header>
    <div class="title">{{ $manuscript->title }}</div>
    <div class="authors">
        @php
            $names = ($manuscript->authors->merge($manuscript->correspondingAuthors))->map(function($author) {
                return $author?->user?->first_name . ' ' . $author?->user?->last_name;
            });
        @endphp
        {{ implode(', ', $names->toArray()) }}
    </div>
    <div class="institution">
        @php
            $institutions = ($manuscript->authors->merge($manuscript->correspondingAuthors))->map(function($author) {
                return $author?->user?->affiliation;
            })->filter(function($institution){return $institution == null ? false : true;});
        @endphp
        {{ implode(', ', $institutions->toArray()) }}
    </div>
    <div class="institution">
        <p>(Received {{ $manuscript->created_at?->format('F j, Y') }}; accepted {{ $manuscript->date_published?->format('F j, Y') }})</p>
    </div>
    <div class="keywords"><b>Keywords:</b> {{ $manuscript->keywords }}</div>
    <div class="abstract">{{ $manuscript->abstract }}</div>
    <footer class="footer">
    <!-- Page <span class="pagenumber"></span> of <span class="pagecount"></span> -->
        <p class="copyright">
            {{ $manuscript->manuscript_no }} © {{ config('app.name') }}
          </p>
        <p class="copyright">
            {{ $manuscript->manuscript_no }} © {{ config('app.name') }}
          </p>
    </footer>
</body>
</html>