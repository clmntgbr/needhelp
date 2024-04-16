'use client';

import useSWR from "swr";
import React from "react";

const fetcher = (url: string | URL | globalThis.Request) => fetch(url).then((res) => res.json());

export default function GetJobById({ params }: { params: { id: string } }) {

  console.log(params)
  const { data, error, isLoading } = useSWR(
    "http://localhost:8070/api/jobs/" + params.id,
    fetcher
  );

  if (isLoading || error) {
    return (
        <>
        </>
    );
  }

    return (
        <div>
            <div className="field-text form-group">
                <label form="Job_title" className="form-control-label required">Title</label>
                <div className="form-widget">
                    <p>{data.title}</p>
                </div>
            </div>
            <br/>
            <div className="field-text form-group">
                <label form="Job_title" className="form-control-label required">Description</label>
                <div className="form-widget">
                    <p>{data.description}</p>
                </div>
            </div>
            <br/>
            <div className="field-text form-group">
                <label form="Job_title" className="form-control-label required">Status</label>
                <div className="form-widget">
                    <p>{data.status}</p>
                </div>
            </div>
        </div>
    );
}
