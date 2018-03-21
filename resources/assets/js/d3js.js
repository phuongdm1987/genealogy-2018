// let data = {
//     "name": "Root",
//     "children": [
//         {
//             "name": "Branch 1"
//         },
//         {
//             "name": "Branch 2",
//             "children": [
//                 {
//                     "name": "Branch 2.1"
//                 },
//                 {
//                     "name": "Branch 2.2",
//                     "children": [
//                         {
//                             "name": "Branch 2.2.1"
//                         },
//                         {
//                             "name": "Branch 2.2.2"
//                         }
//                     ]
//                 }
//             ]
//         },
//         {
//             "name": "Branch 3"
//         },
//         {
//             "name": "Branch 4",
//             "children": [
//                 {
//                     "name": "Branch 4.1"
//                 },
//                 {
//                     "name": "Branch 4.2"
//                 }
//             ]
//         },
//         {
//             "name": "Branch 5"
//         }
//     ]
// };
// console.log(data);
d3.json('http://genealogy.test:81/maps', function(error, json) {
    let data = json;

    let split_index = Math.round(data.children.length / 2)

    // Left data
    let dataLeft = {
        "name": data.name,
        "children": JSON.parse(JSON.stringify(data.children.slice(0, split_index)))
    };

    // Right data
    let dataRight= {
        "name": data.name,
        "children": JSON.parse(JSON.stringify(data.children.slice(split_index)))
    };

    // Create d3 hierarchies
    let right = d3.hierarchy(dataLeft);
    let left = d3.hierarchy(dataRight);

    // Render both trees
    drawTree(right, "right")
    drawTree(left, "left")

    // draw single tree
    function drawTree(root, pos) {

        let SWITCH_CONST = 1;
        if (pos === "left") {
            SWITCH_CONST = -1;
        }

        let svg = d3.select("svg"),
            width = +svg.attr("width"),
            height = +svg.attr("height")

        // Shift the entire tree by half it's width
        let g = svg.append("g").attr("transform", "translate(" + width / 2 + ",0)");

        // Create new default tree layout
        let tree = d3.tree()
        // Set the size
        // Remember the tree is rotated
        // so the height is used as the width
        // and the width as the height
            .size([height, SWITCH_CONST * (width - 150) / 2]);

        tree(root)

        let nodes = root.descendants();
        let links = root.links();
        // Set both root nodes to be dead center vertically
        nodes[0].x = height / 2

        // Create links
        let link = g.selectAll(".link")
            .data(links)
            .enter()

        link.append("path")
            .attr("class", "link")
            .attr("d", function(d) {
                return "M" + d.target.y + "," + d.target.x + "C" + (d.target.y + d.source.y) / 2.5 + "," + d.target.x + " " + (d.target.y + d.source.y) / 2 + "," + d.source.x + " " + d.source.y + "," + d.source.x;
            });

        // Create nodes
        let node = g.selectAll(".node")
            .data(nodes)
            .enter()
            .append("g")
            .attr("class", function(d) {
                return "node" + (d.children ? " node--internal" : " node--leaf");
            })
            .attr("transform", function(d) {
                return "translate(" + d.y + "," + d.x + ")";
            })

        node.append("circle")
            .attr("r", function(d, i) {
                return 2.5
            });

        node.append("text")
            .attr("dy", 3)
            .style("text-anchor", "middle")
            .text(function(d) {
                return d.data.name
            });
    }
});

