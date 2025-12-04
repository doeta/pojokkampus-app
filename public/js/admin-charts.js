// Admin Dashboard Charts
function initAdminCharts(chartData) {
    if (!chartData) {
        console.error("Chart data not provided");
        return;
    }

    // Chart Colors
    const colors = [
        "#14b8a6",
        "#0d9488",
        "#0f766e",
        "#115e59",
        "#134e4a",
        "#06b6d4",
        "#0891b2",
        "#0e7490",
        "#155e75",
        "#164e63",
    ];

    // 1. Products by Category Chart
    const productsByCategoryCtx = document.getElementById(
        "productsByCategoryChart"
    );
    if (productsByCategoryCtx) {
        new Chart(productsByCategoryCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.productCategoryNames,
                datasets: [
                    {
                        label: "Jumlah Produk",
                        data: chartData.productCategoryTotals,
                        backgroundColor: colors[0],
                        borderColor: colors[1],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                    },
                },
            },
        });
    }

    // 2. Stores by Province Chart
    const storesByProvinceCtx = document.getElementById(
        "storesByProvinceChart"
    );
    if (storesByProvinceCtx) {
        new Chart(storesByProvinceCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.provinceNames,
                datasets: [
                    {
                        label: "Jumlah Toko",
                        data: chartData.provinceTotals,
                        backgroundColor: colors[5],
                        borderColor: colors[6],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: "y",
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                    },
                },
            },
        });
    }

    // 3. Seller Status Chart
    const sellerStatusCtx = document.getElementById("sellerStatusChart");
    if (sellerStatusCtx) {
        new Chart(sellerStatusCtx.getContext("2d"), {
            type: "pie",
            data: {
                labels: ["Aktif", "Tidak Aktif"],
                datasets: [
                    {
                        data: [
                            chartData.sellerActiveCount,
                            chartData.sellerInactiveCount,
                        ],
                        backgroundColor: [colors[0], "#ef4444"],
                        borderWidth: 2,
                        borderColor: "#fff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });
    }

    // 4. Review Statistics Chart (SRS-06: Guest Reviews)
    const participationCtx = document.getElementById("participationChart");
    if (participationCtx) {
        new Chart(participationCtx.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: ["Total Review", "Reviewer Unik"],
                datasets: [
                    {
                        data: [
                            chartData.totalReviews,
                            chartData.uniqueReviewers,
                        ],
                        backgroundColor: [colors[0], colors[5]],
                        borderWidth: 2,
                        borderColor: "#fff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });
    }
}

// Auto-init when DOM is ready - reads data from HTML data attributes
function loadChartDataFromDOM() {
    const dataElement = document.getElementById("chartData");
    if (!dataElement) {
        console.error("Chart data element not found");
        return;
    }

    try {
        const chartData = {
            productCategoryNames: JSON.parse(
                dataElement.dataset.productCategoryNames || "[]"
            ),
            productCategoryTotals: JSON.parse(
                dataElement.dataset.productCategoryTotals || "[]"
            ),
            provinceNames: JSON.parse(
                dataElement.dataset.provinceNames || "[]"
            ),
            provinceTotals: JSON.parse(
                dataElement.dataset.provinceTotals || "[]"
            ),
            sellerActiveCount: parseInt(
                dataElement.dataset.sellerActive || "0"
            ),
            sellerInactiveCount: parseInt(
                dataElement.dataset.sellerInactive || "0"
            ),
            totalReviews: parseInt(dataElement.dataset.totalReviews || "0"),
            uniqueReviewers: parseInt(
                dataElement.dataset.uniqueReviewers || "0"
            ),
        };

        initAdminCharts(chartData);
    } catch (error) {
        console.error("Error parsing chart data:", error);
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", loadChartDataFromDOM);
} else {
    loadChartDataFromDOM();
}
