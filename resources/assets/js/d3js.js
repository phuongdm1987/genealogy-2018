d3.json('http://genealogy.test:81/maps', function (error, data) {
    if (error) throw error;

    let svg = d3.select("svg"),
        width = $('svg').width(),
        height = $('svg').height(),
        g = svg.append("g").attr("transform", "translate(100,0)");

    let tree = d3.tree()
        .size([height, width - 200]);

    let stratify = d3.stratify().parentId(function (d) {
        if (d.parent_id <= 0) {
            return null;
        }

        return d.parent_id;
    });

    let root = stratify(data)
        .sort(function (a, b) {
            return (a.height - b.height) || a.id.localeCompare(b.id);
        });

    g.selectAll(".link")
        .data(tree(root).links())
        .enter().append("path")
        .attr("class", "link")
        .attr("d", d3.linkHorizontal()
            .x(function (d) {
                return d.y;
            })
            .y(function (d) {
                return d.x;
            }));

    let node = g.selectAll(".node")
        .data(root.descendants())
        .enter().append("g")
        .attr("class", function (d) {
            return "node" + (d.children ? " node--internal" : " node--leaf");
        })
        .attr("transform", function (d) {
            return "translate(" + d.y + "," + d.x + ")";
        });

    node.append("circle")
        .attr("r", 2.5);

    node.append("text")
        .attr("dy", 3)
        .attr("x", function (d) {
            return d.children ? -8 : 8;
        })
        .style("text-anchor", function (d) {
            return d.children ? "end" : "start";
        })
        .text(function (d) {
            return d.data.full_name;
        });
});
