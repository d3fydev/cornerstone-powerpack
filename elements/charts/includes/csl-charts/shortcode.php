<?php $time = time(); ?>
<div id="chart-<?php echo $time; ?>"></div>
<script type="text/javascript">
(function(d3) {
  'use strict';

  // Data loading
  var dataSet = [
    <?php echo $content; ?>
  ];

  // Common settings
  var width = <?php echo $width; ?>;
  var height = <?php echo $height; ?>;
  var color = d3.scaleOrdinal(<?php echo $color_scheme; ?>)
  var svg = d3.select('#chart-<?php echo $time; ?>')
    .append('svg')
    .attr('width', width)
    .attr('height', height);

  function isViewable() {
    return document.getElementById('chart-<?php echo $time; ?>')
        .getBoundingClientRect()
        .bottom <= (window.innerHeight || document.documentElement.clientHeight)
  }

  function onView(applyTransition) {
    if (isViewable()) {
      applyTransition();
    } else {
      window.addEventListener('scroll', function handler(e) {
        if (isViewable()) {
          this.removeEventListener('scroll', handler);
          applyTransition();
        }
      });
    }
  }

  <?php if ($chart_style === 'donut' || $chart_style === 'pie'): ?>
    if (dataSet.length === 1) {
      dataSet.push({
        label: "None",
        value: 100 - dataSet[0].value,
      })
    }

    var radius = Math.min(width, height) / 2;
    var donutWidth = radius / 2;

    var innerG = svg.append('g')
        .attr('transform', 'translate(' + (width / 2) + ',' + (height / 2) + ')');

    var arc = d3.arc()
      <?php if ($chart_style === 'donut'): ?>
        .innerRadius(radius - donutWidth)
      <?php else: ?>
        .innerRadius(0)
      <?php endif; ?>
      .outerRadius(radius);

    var pie = d3.pie()
      .value(function(d) {
        return d.value;
      })
      .sort(null);

    var slice = innerG.selectAll('path')
      .data(pie(dataSet))
    var g = slice.enter()
              .append('g');
    var path = g.append('path')
        .attr('fill', function(d, i) {
          return color(i);
        })
    
    onView(
      function() {
        path.transition()
        .duration(1000)
        .attrTween("d", function(d) {
          var i = d3.interpolate({
            startAngle: 1.1 * Math.PI,
            endAngle: 1.1 * Math.PI
          }, d);
          return function(t) { return arc(i(t)); };
        });

        var div = d3.select("body").append("div").attr("class", "toolTip");
        g.on("mousemove", function(d) {
            div.style("left", d3.event.pageX+10+"px");
            div.style("top", d3.event.pageY-25+"px");
            div.style("display", "inline-block");
            div.html((d.data.label) + "<br />" + (d.data.value) + "%");
          })
          .on("mouseout", function(d){
            div.style("display", "none");
          });
        g.append('text')
          .attr('transform', function(d) {
            var _d = arc.centroid(d);
            return 'translate(' + _d + ')';
          })
          .style('text-anchor', 'middle')
          .text(function(d) {
            return d.value + '%';
          });
      }
    );

  <?php elseif ($chart_style === 'bar'): ?>
    var margin = {
      top: 20,
      right: 20,
      bottom: 30,
      left: 40
    }
    var innerHeight = height - margin.top - margin.bottom;
    var innerWidth = width - margin.left - margin.right;

    var innerG = svg.append('g')
      .attr(
        'transform',
        'translate(' + margin.left + ',' + margin.top + ')'
      );

    var x = d3.scaleBand()
      .domain(dataSet.map(function(d) {
        return d.label;
      }))
      .rangeRound([0, innerWidth])
      .padding([0.05]);
    var y = d3.scaleLinear()
      .domain([
        0,
        d3.max(dataSet, function(d) {
          return d.value;
        })
      ])
      .range([
        innerHeight,
        0
      ]);
    var bar = innerG.selectAll('g')
      .data(dataSet)
      .enter()
        .append('g')
        .attr('transform', function(d) {
          return 'translate(' + x(d.label) + ',0)'
        })
    var shape = bar.append('rect')
      .attr('height', 0)
      .attr('y', y(0))
      .attr('width', x.bandwidth())
      .attr('fill', function(d, i) {
        return color(i);
      })

    onView(
      function() {
        shape.transition()
        .delay(function(d, i) {
          return i * 20
        })
        .duration(800)
        .attr('y', function(d) {
          return y(d.value)
        })
        .attr('height', function(d) {
          return innerHeight - y(d.value);
        })
      }
    );

    innerG.append('g')
      .attr('transform', 'translate(0, ' + innerHeight + ')')
      .call(d3.axisBottom(x));
    innerG.append('g')
      .attr('transform', 'translate(0, 0)')
      .call(d3.axisLeft(y));
  <?php endif; ?>
})(window.d3);
</script>
