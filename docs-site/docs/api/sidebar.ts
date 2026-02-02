import type { SidebarsConfig } from "@docusaurus/plugin-content-docs";

const sidebar: SidebarsConfig = {
  apisidebar: [
    {
      type: "doc",
      id: "api/dreampay-api",
    },
    {
      type: "category",
      label: "Authentication",
      link: {
        type: "doc",
        id: "api/authentication",
      },
      items: [
        {
          type: "doc",
          id: "api/0903-f-2-e-0-df-1-a-8857-bee-538-fc-055417-f-0",
          label: "Register a new Santri account",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/2-dd-578-ff-7-aba-2721293-dac-66833-b-27-d-1",
          label: "Login to get access token",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/68-a-6108-af-04-af-5-e-3-bc-1-ea-68-a-6-c-6-f-1299",
          label: "Logout and revoke current token",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/e-92-c-58-f-994-e-8-be-6-e-19813-ce-20425-f-83-e",
          label: "Get authenticated user profile",
          className: "api-method get",
        },
      ],
    },
    {
      type: "category",
      label: "Merchant",
      link: {
        type: "doc",
        id: "api/merchant",
      },
      items: [
        {
          type: "doc",
          id: "api/db-67-b-6-c-34-a-89-c-033-f-589-ba-1-ab-5413-ce-3",
          label: "Merchant scans Santri QR Code to process payment",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/352-bfc-8-eb-33293-bee-70173611431-de-40",
          label: "List merchant products",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/2-c-96-aa-2-b-26-d-34-a-7-a-9-eef-3084-fd-964476",
          label: "Add a new product",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/cee-85910271653119-c-9-c-90-e-195-d-75533",
          label: "Get merchant sales history",
          className: "api-method get",
        },
      ],
    },
    {
      type: "category",
      label: "Split Bill",
      link: {
        type: "doc",
        id: "api/split-bill",
      },
      items: [
        {
          type: "doc",
          id: "api/03-ca-0-bc-2-ec-34442-c-6-e-57-eedbd-65-b-3144",
          label: "Create a new Split Bill",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/ce-2-ceb-015-f-68-d-1308-c-910086-c-25-c-4-cba",
          label: "Pay a specific Split Bill member share",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/51-f-3-d-7-ed-693-d-6-c-0353-dbd-06-d-0-ca-82-da-7",
          label: "Get bills created by me",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/a-5-d-604-ad-9699-e-50-cce-2-a-1-d-3720-a-49597",
          label: "Get bills I need to pay",
          className: "api-method get",
        },
      ],
    },
    {
      type: "category",
      label: "Topups",
      link: {
        type: "doc",
        id: "api/topups",
      },
      items: [
        {
          type: "doc",
          id: "api/df-2152-d-32-d-0-ebd-292180325-e-013-e-4958",
          label: "List all topup requests (Admin)",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/b-2046184933-ecb-26817-bf-2936-dc-5-e-85-c",
          label: "Create a new topup (Admin/Gateway)",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/9467-fc-90918-d-25-dbd-6-aa-463-d-3-c-4-a-6-d-04",
          label: "Get topup details",
          className: "api-method get",
        },
      ],
    },
    {
      type: "category",
      label: "Transactions",
      link: {
        type: "doc",
        id: "api/transactions",
      },
      items: [
        {
          type: "doc",
          id: "api/716-a-962-b-580-bc-03-cf-3-aa-45-dc-2-ab-6-c-0-e-2",
          label: "List all transactions (Admin)",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/238-affdbe-033-b-73010-cbace-3-ad-94520-e",
          label: "Create a new payment transaction",
          className: "api-method post",
        },
        {
          type: "doc",
          id: "api/3688-d-1698-c-27896038-b-253-d-006-a-06-fd-6",
          label: "Get authenticated user transaction history",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/2-a-6-d-0-d-9-d-6950359-d-14-a-92-f-71-c-3-a-55-b-6-d",
          label: "Get transaction details",
          className: "api-method get",
        },
        {
          type: "doc",
          id: "api/0670936002-ac-78-e-8461472-cab-670-a-411",
          label: "Transfer balance to another user",
          className: "api-method post",
        },
      ],
    },
  ],
};

export default sidebar.apisidebar;
