@if($ad)
    @foreach($ad->media_img as $img)
        @php $imageArray = media_url($img, true) @endphp
    @endforeach
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "Product",
          "name": "{{ $ad->title }}",
          "image": "{{ $imageArray }}",
          "description": "{!! strip_tags($ad->description) !!}",
          "sku": "{{ $ad->sku }}",
          "mpn": "",
          "brand": {
            "@type": "Thing",
            "name": "{{ $ad->brand->brand_name }}"
          },
          "review": {
            "@type": "Review",
            "reviewRating": {
              "@type": "Rating",
              "ratingValue": "4",
              "bestRating": "5"
            },
            "author": {
              "@type": "Person",
              "name": "{{ $ad->seller_name }}"
            }
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.4",
            "reviewCount": "89"
          },
          "offers": {
            "@type": "Offer",
            "url": "{{ url()->full()  }}",
            "priceCurrency": "VND",
            "price": "{{ $ad->price }}",
            "priceValidUntil": "{{ date('Y-m-d', strtotime('+5 years')) }}",
            "itemCondition": "https://schema.org/UsedCondition",
            "availability": "https://schema.org/InStock",
            "seller": {
              "@type": "Organization",
              "name": "{{ $ad->seller_name }}"
            }
          }
        }
    </script>
@endif