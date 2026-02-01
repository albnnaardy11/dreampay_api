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
      ],
    },
  ],
};

export default sidebar.apisidebar;
